# Open Hours plugin for Craft CMS 3.x

Add a field type for open hours

![Screenshot](resources/img/plugin-logo.png)


## Installation

1. Open your terminal and go to your Craft project:

        cd /path/to/project
        
2. Add Github repo to your `composer.json`

        "repositories": [
            {
              "type":"git",
              "url":"https://github.com/simple-integrated-marketing/open-hours"
            }
        ]

3. Then tell Composer to load the plugin:

        composer require "simple-team/open-hours:dev-master"

4. In the Control Panel, go to Settings → Plugins and click the “Install” button for Open Hours.

## Usage

In template the field is a JSON formatted string. To convert it into an array for you to use in twig, you will need to use

```twig
{{ entry.fieldName | openHours }}
{{ openHours(entry.fieldName) }}
```

Brought to you by [Simple Integrated Marketing](https://simple.com.au)
