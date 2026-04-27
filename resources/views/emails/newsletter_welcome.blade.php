<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Newsletter Subscription</title>
</head>

<body style="margin:0; padding:0; background:#f4f6fb; font-family: Arial, Helvetica, sans-serif;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6fb; padding:24px 0;">
    <tr>
      <td align="center">

        <!-- Container -->
        <table role="presentation" width="600" cellpadding="0" cellspacing="0"
               style="width:600px; max-width:92%; background:#ffffff; border-radius:14px; overflow:hidden; box-shadow:0 8px 30px rgba(0,0,0,.08);">
          <!-- Header -->
          <tr>
            <td style="padding:24px 24px 10px; text-align:center; background:#ffffff;">
              <img
                src="{{ config('app.url') . '/images/logo/logo.png' }}"
                alt="Company Logo"
                style="height:58px; width:auto; display:block; margin:0 auto;"
              >
            </td>
          </tr>

          <!-- Body -->
          <tr>
            <td style="padding:12px 24px 0;">
              <h1 style="margin:0; font-size:24px; line-height:1.3; color:#111827; text-align:center;">
                Thanks for subscribing 🎉
              </h1>

              <p style="margin:14px 0 0; font-size:14px; line-height:1.7; color:#6b7280; text-align:center;">
                Hello <b style="color:#111827;">{{ $email }}</b>,<br>
                You have successfully subscribed to our newsletter.
              </p>

              <!-- Info box -->
              <div style="margin:18px 0 0; padding:16px; background:#f6f8ff; border:1px solid #e6e9ff; border-radius:12px;">
                <p style="margin:0; font-size:14px; line-height:1.7; color:#374151;">
                  You’ll now receive updates about new campaign, reports, and important announcements.
                  If this wasn’t you, you can unsubscribe anytime using the button below.
                </p>
              </div>

              <!-- Button -->
              <div style="text-align:center; padding:22px 0 10px;">
                <a href="{{ $unsubscribeUrl }}"
                   style="display:inline-block; background:#dc2626; color:#ffffff; text-decoration:none; font-weight:700;
                          padding:12px 18px; border-radius:10px; font-size:14px;">
                  Unsubscribe
                </a>
              </div>

              <p style="margin:18px 0 0; font-size:14px; line-height:1.7; color:#374151;">
                Thanks,<br>
                <b>SOUTH AMERICAN INITIATIVE</b>
              </p>

              <hr style="border:none; border-top:1px solid #eef2f7; margin:22px 0;">

              <p style="margin:0 0 22px; font-size:12px; line-height:1.6; color:#9ca3af; text-align:center;">
                You received this email because you subscribed to our newsletter.
              </p>
            </td>
          </tr>
        </table>
        <!-- /Container -->

      </td>
    </tr>
  </table>
</body>
</html>
