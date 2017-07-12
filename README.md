# Event Logger

The Perch Event Logger tracks the activity of users with access to your CMS. This can be useful when assisting clients or for auditing your content editors.

![Admin](https://redfinch.github.io/Perch-Event-Logger/admin-preview.png)

## Installation

### Requirements

* PHP >= 5.4
* Perch / Runway >= 3.0

### Adding to Perch

Upload the `redfinch_logger` directory to `perch/addons/apps`. Once complete you should see the app appear in the sidebar menu.

Initially the *Type*, *Action* and *User* filters may be empty - these will be populated as the number of events logged increases.

### Configuration

Logs can be automatically deleted after a set number of days. If you wish this to occur, please set the length of time to keep logs (1, 3, 6 or 12 months) and make sure that Perch's [scheduled tasks](https://docs.grabaperch.com/perch/getting-started/installing/scheduled-tasks/) are operational.

## What is Logged

The list of events that are tracked include:

* item.delete
* region.truncate
* region.share
* region.unshare
* region.undo
* region.publish
* region.delete
* collection.publish_item
* assets.upload_image

Certain events include a history tab that shows changes over time. Asset based events will attempt to show a preview of the uploaded image, however if the log is older or the asset is deleted this may not always be possible.
