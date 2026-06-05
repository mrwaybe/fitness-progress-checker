# Administrator Guide

### Link-Local Network Configuration (Demo Setup)
To operate the application strictly offline for the demonstration using the Raspberry Pi Zero 2W:
1. Disable the WiFi interface to ensure isolation: `sudo rfkill block wifi`
2. Enable USB Ethernet Gadget mode to allow a direct connection to a laptop.
3. Assign a static link-local IP address (e.g., `169.254.10.1`) to the USB network interface within the Raspberry Pi's network configuration file (e.g., `/etc/dhcpcd.conf` or via the `dietpi-config` tool).

### Database Management
To create a manual backup of the fitness logs and user data:
`mysqldump -u root -p fitness_tracker > database_backup.sql`

To verify the MariaDB service is running correctly:
`sudo systemctl status mariadb`

### Server Maintenance
If changes are made to the PHP configuration or the Nginx server blocks, restart the services to apply the updates:
`sudo systemctl restart nginx`
`sudo systemctl restart php-fpm`