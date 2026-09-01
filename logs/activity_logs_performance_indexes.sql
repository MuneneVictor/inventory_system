-- Optional performance indexes for activity_logs.
-- Run once if these indexes do not already exist in your database.

CREATE INDEX idx_activity_logs_created_at_id
    ON activity_logs (created_at, id);

CREATE INDEX idx_activity_logs_user_created_at
    ON activity_logs (user_id, created_at);
