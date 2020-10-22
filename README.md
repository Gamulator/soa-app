## SOA app

This project contains two web applications. It's made with a single Yii2 core (advanced template), but can be easily separated into two apps on different locations.  

One of apps (the Client app) has a widget (CommentWidget) that can save data (users comments) to another app (the Server app) and retrieve data for display.

Demo: **[Client](https://soa-client.lifous.com/)** and **[Server](https://soa-server.lifous.com/)**

Application components:

- **[Yii2 Framework](https://www.yiiframework.com/)** as a backend core
- **[JSON-RPC extension](https://github.com/datto/php-json-rpc)** for parsing and evaluating JSON-RPC requests (compliant with the JSON-RPC 2.0 specifications)
- **[PostgreSQL](https://www.postgresql.org/)** as a data storage for server side
