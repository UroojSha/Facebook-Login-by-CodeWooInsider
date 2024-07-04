# Facebook Login Plugin for WordPress



## Introduction

Welcome to the Facebook Login Plugin by CodeWooInsider! This plugin enables seamless Facebook login functionality on your WordPress website, allowing users to authenticate using their Facebook credentials. This integration is powered by the Facebook SDK for PHP and provides a straightforward, customizable solution for adding social login capabilities to your site.

## Features

- **Facebook Integration:** Effortlessly connect your WordPress site with Facebook for user authentication.
- **Shortcode Integration:** Add the login button anywhere on your site using `[fb_login_button]`.
- **User Registration:** Automatically creates new WordPress accounts for first-time Facebook logins.
- **Session Management:** Manages user sessions and redirects efficiently.
- **Customizable:** Easily tailor the plugin to meet your specific website requirements.

## Installation

1. **Download the Plugin:**
   - Clone the repository to your WordPress plugins directory or download the latest release ZIP file from GitHub.

2. **Activate the Plugin:**
   - Navigate to the WordPress admin panel, go to Plugins, and click Activate.

3. **Enter Facebook App Credentials:**
   - Go to `Settings -> Facebook Login` in your WordPress admin panel and enter your Facebook App ID and App Secret.

## Configuration

### Facebook App Setup

1. **Create a Facebook App:**
   - Visit the [Facebook Developers Portal](https://developers.facebook.com/apps) and create a new app.
   
2. **Configure App Settings:**
   - Navigate to `Settings -> Basic`.
   - Add your website URL in the "App Domains" field.
   - Scroll down to "Add Platform," select "Website," and add your site URL in the "Site URL" field.

3. **Setup Redirect URI:**
   - Go to `Settings -> Advanced -> Client OAuth Settings`.
   - Scroll down to "Valid OAuth Redirect URIs" and add your site URL followed by the path to the Facebook login callback (e.g., `https://yourwebsite.com/wp-admin/admin-ajax.php?action=fb_login_callback`).

### Plugin Configuration

1. **Add App Credentials:**
   - In your code editor, open the plugin file and locate the lines where the Facebook SDK is initialized.
   - Replace `YOUR_APP_ID` and `YOUR_APP_SECRET` with the credentials obtained from the Facebook Developer Portal.

2. **Save and Upload:**
   - Save your changes and upload the plugin folder to your WordPress site.

## Usage

### Shortcode

To display the Facebook login button on your site, use the following shortcode in your posts, pages, or widgets:

```shortcode
[fb_login_button]
Frequently Asked Questions
How do I obtain a Facebook App ID and App Secret?
You can create a new Facebook App by visiting the Facebook Developers Portal.

Can I customize the appearance of the login button?
Yes, you can customize the button using CSS or by modifying the plugin's templates as needed.

Support
For support or inquiries, please contact urooj_shafait292@hotmail.com

Contributing
Contributions are welcome! Feel free to fork the repository and submit pull requests.

License
This project is licensed under the MIT License - see the LICENSE file for details.

vbnet
Copy code

**Professional LinkedIn Post:**

🚀 Excited to announce my latest development! 🚀

I’ve just created a custom Facebook Login plugin for WordPress, allowing seamless integration of third-party APIs into your website. With this lightweight and efficient plugin, users can log in to your site using their Facebook credentials, enhancing user experience and simplifying authentication.

🔧 Key Features:
- Easy setup and configuration
- Direct integration with Facebook SDK
- No third-party plugins required
- Secure and efficient authentication process

🌐 Check out the plugin and detailed setup guide on my GitHub: https://github.com/UroojSha

🎥 Watch the full tutorial on YouTube: https://youtu.be/A7iVu6gf5e8?si=bjcvX1h_gnNheszG

📂 Explore my portfolio to see more of my work: https://code-woo-insider.free.nf/

As I continue to grow and develop innovative solutions, I'm also on the lookout for new job opportunities. If you know of any openings for a passionate web developer with expertise in WordPress and API integrations, please feel free to reach out!

#WordPress #FacebookLogin #WebDevelopment #Coding #PluginDevelopment #APIIntegration #TechInnov
