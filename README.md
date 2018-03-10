# HetznerCloudPhpClient
This is the PHP Client for Hetzner Cloud API (Developed from Hetzner Root Servers PHP Client API). with this Codes, you can Connect to your Hetzner Cloud Projects and Do Actions on your Servers. also you need Different ACCESS TOKENS for any Hetzner Cloud Projects.

# Hetzner Root Servers PHP Client
you can Download PHP Client for Hetzner Root Servers from (https://robot.your-server.de/doc/webservice/en.html).

# Supported Functions
```php
/* SERVERS */
GetServers($id = null)
CreateServer($name, $serverType, $datacenter = null, $location = null, $startAfterCreate = true, $image, $sshKeys = null, $userData = null)

/* SERVER ACTIONS */
PowerOnServer($id = null)
SoftRebootServer($id = null)
ResetServer($id = null)
ShutdownServer($id = null)
PowerOffServer($id = null)

/* SERVER TYPES */
GetServerTypes($id = null)

/* LOCATIONS */
GetLocations($id = null)

/* DATA CENTERS */
GetDatacenters($id = null)
```

# Usage
just you need to Run main.php and set this Parameters: (ACCESS TOKEN and API URL). Enjoy !
Please send your comments for ipmrovements.
