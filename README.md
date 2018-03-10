# HetznerCloudPhpClient
This is the PHP Client for Hetzner Cloud API (Developed from Hetzner Root Servers PHP Client). with this Codes, you can connect to your Hetzner Cloud Projects and Do Actions on you servers. also you need Different ACCESS TOKENS for any Hetzner Cloud Projects.

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
just you need to Run main.php and set this Parameters: (ACCESS TOKEN and API URL)
