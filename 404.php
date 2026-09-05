<?php
// Generic error page.
// Do not expose internal paths, permissions, roles, or resource details.

http_response_code(404);

// Prevent browsers/search engines from indexing error pages.
header('X-Robots-Tag: noindex, nofollow', true);
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Page Not Found</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: #f5f7fb;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
                         Helvetica, Arial, sans-serif;
            color: #1f2937;
        }

        .error-container {
            width: 100%;
            max-width: 620px;
            text-align: center;
        }

        .error-code {
            font-size: clamp(90px, 20vw, 160px);
            line-height: 0.9;
            font-weight: 800;
            letter-spacing: -8px;
            color: #2563eb;
            margin-bottom: 30px;
        }

        h1 {
            font-size: clamp(28px, 5vw, 38px);
            font-weight: 700;
            margin-bottom: 14px;
            color: #111827;
        }

        .message {
            max-width: 470px;
            margin: 0 auto 32px;
            font-size: 16px;
            line-height: 1.7;
            color: #6b7280;
        }

        .actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            min-width: 145px;
            padding: 13px 22px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: 0.2s ease;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: #ffffff;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        .btn-secondary {
            background: #ffffff;
            color: #374151;
            border-color: #d1d5db;
        }

        .btn-secondary:hover {
            background: #f9fafb;
        }

        @media (max-width: 480px) {
            .error-code {
                letter-spacing: -4px;
            }

            .actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="error-container">

    <div class="error-code">404</div>

    <h1>Page Not Found</h1>

    <p class="message">
        The page you are looking for could not be found.
        Please check the address or return to the previous page.
    </p>

    <div class="actions">
        <button type="button"
                class="btn btn-secondary"
                onclick="history.back()">
            Go Back
        </button>

        <a href="/" class="btn btn-primary">
            Return Home
        </a>
    </div>

</div>

</body>
</html>