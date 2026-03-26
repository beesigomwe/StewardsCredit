<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_controller extends Admin_Core_Controller{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Update Sitemap
     */
    public function update_sitemap()
    {
        $this->load->model('sitemap_model');
        $this->sitemap_model->update_sitemap();
    }

    /**
     * Send Due Payment Alerts
     *
     * Runs daily via server cron job. Queries the `alerts` table for
     * unsent alerts whose due_date is today or has passed, then sends
     * an email to the account owner and marks the alert as sent.
     *
     * Server cron entry (run daily at 8:00am):
     *   0 8 * * * curl -s "https://yourdomain.com/cron_controller/send_due_payment_alerts?key=YOUR_CRON_SECRET_KEY"
     *
     * Set CRON_SECRET_KEY in your server environment variables.
     */
    public function send_due_payment_alerts()
    {
        // Protect the endpoint: require a secret key query parameter
        $key      = $this->input->get('key', true);
        $expected = getenv('CRON_SECRET_KEY') ?: 'change_this_secret';
        if (!$this->input->is_cli_request() && $key !== $expected) {
            show_error('Forbidden', 403);
            return;
        }

        $today = date('Y-m-d');

        // Fetch all unsent alerts that are due today or overdue
        $this->db->where('is_sent', 0);
        $this->db->where('due_date <=', $today);
        $alerts = $this->db->get('alerts')->result();

        if (empty($alerts)) {
            echo "[" . date('Y-m-d H:i:s') . "] No due alerts to send.\n";
            return;
        }

        $sent   = 0;
        $failed = 0;

        foreach ($alerts as $alert) {
            // Load the account and its owner
            $post = $this->post_model->get_post_by_id($alert->post_id);
            if (!$post || empty($post->owner->email)) {
                // Mark as sent to avoid retrying accounts with no email
                $this->db->where('alert_id', $alert->alert_id);
                $this->db->update('alerts', [
                    'is_sent' => 1,
                    'sent_at' => date('Y-m-d H:i:s'),
                    'note'    => 'Skipped: no email on file',
                ]);
                continue;
            }

            $email_data = [
                'subject'       => 'Payment Due Reminder — ' . $this->settings->application_name,
                'to'            => $post->owner->email,
                'template_path' => 'email/email_alert',
                'post'          => $post,
                'alert'         => $alert,
                'settings'      => $this->settings,
            ];

            $result = $this->email_model->send_email($email_data);

            if ($result) {
                $this->db->where('alert_id', $alert->alert_id);
                $this->db->update('alerts', [
                    'is_sent' => 1,
                    'sent_at' => date('Y-m-d H:i:s'),
                ]);
                $sent++;
            } else {
                $failed++;
            }
        }

        echo "[" . date('Y-m-d H:i:s') . "] Alerts sent: {$sent}, Failed: {$failed}\n";
    }

    /**
     * Create Alert (POST)
     * Allows admins to schedule a payment due alert for an account.
     * Called from the account page alerts tab.
     */
    public function create_alert_post()
    {
        if (!auth_check() || !is_admin()) {
            echo json_encode(['success' => false, 'message' => 'Unauthorised.']);
            return;
        }
        $post_id     = $this->input->post('post_id', true);
        $due_date    = $this->input->post('due_date', true);
        $amount_due  = $this->input->post('amount_due', true);
        $description = $this->input->post('description', true);

        if (empty($post_id) || empty($due_date)) {
            echo json_encode(['success' => false, 'message' => 'Account and due date are required.']);
            return;
        }

        $data = [
            'post_id'     => $post_id,
            'due_date'    => date('Y-m-d', strtotime($due_date)),
            'amount_due'  => !empty($amount_due) ? (float)str_replace(',', '', $amount_due) : null,
            'description' => $description,
            'is_sent'     => 0,
            'created_by'  => user()->id,
            'created_at'  => date('Y-m-d H:i:s'),
        ];

        $this->db->insert('alerts', $data);
        $alert_id = $this->db->insert_id();

        if ($alert_id) {
            echo json_encode(['success' => true, 'message' => 'Alert scheduled successfully.', 'alert_id' => $alert_id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create alert.']);
        }
    }

    /**
     * Delete Alert (POST)
     */
    public function delete_alert_post()
    {
        if (!auth_check() || !is_admin()) {
            echo json_encode(['success' => false, 'message' => 'Unauthorised.']);
            return;
        }
        $alert_id = $this->input->post('alert_id', true);
        $this->db->where('alert_id', $alert_id);
        $this->db->delete('alerts');
        echo json_encode(['success' => true, 'message' => 'Alert deleted.']);
    }
}
