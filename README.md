# 🔥 CodeIgniter 3 Project 🔥

This project was developed using the CodeIgniter 3 framework. <br /><br />

**IMPORTANT**: Here you will **ONLY** find ways to run this project. If you want more specific information about the developed project and its contexts, visit: [DOC.md](./docs/DOC.md).

<br />

# 🚀 Running 🚀

For LINUX:
- Via Docker;
- Natively via LAMP.

For Windows:
- Via Docker;
- Via XAMPP/WAMPP.

**PS: The easiest ways have been listed, but feel free to run the project in the way that suits you best.**

<br />

# 🐋 Docker 🐋 (For Linux and Windows)

### ❗🛑 REQUIREMENTS 🛑❗
- PHP 7.4+ with Composer (For small internal command line uses only)
- Docker 

For both Linux and Windows there are two ways to run the project through the Docker:
- **Via Makefile**: Easiest way, but requires Makefile package. Normally, the Makefile package will already be installed on Linux distributions because it is native.
- **Docker run command**: It's also an easier way, but the command to run it is a bit long.

## Via Makefile:

Simply run the following command: `make d-start`. <br />
To stop, run: `make d-stop`.

## Purely via docker:

Run the following command: `docker-compose --env-file ./.docker.env up -d`. <br />
To stop, run: `docker-compose --env-file ./.docker.env down`.

<br />

# 🛠 LAMP/XAMPP/WAMPP 🛠

In order not to extend this README.md too much, we will recommend three tutorials to configure all of the aforementioned development environments.

## LAMP (For Linux)

- **Ubuntu**: [From DigitalOcean](https://www.digitalocean.com/community/tutorials/como-instalar-a-pilha-linux-apache-mysql-php-lamp-no-ubuntu-18-04-pt);
- **Debian**: [From DigitalOcean](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mariadb-php-lamp-stack-debian9-pt);
- **Manjaro**: [From LinuxAndUbuntu](https://www.linuxandubuntu.com/home/install-lamp-on-manjaro);
- **Fedora**: [From ComputingForGeeks](https://computingforgeeks.com/how-to-install-lamp-stack-on-fedora/).

If your linux distro is not on this list, just Google it: `lamp configuration YOUR_DISTRO`.

## XAMPP/WAMPP (For Windows)

- **XAMPP**: [From c-sharpcorner](https://www.c-sharpcorner.com/article/how-to-install-and-configure-xampp-in-windows-10/);
- **WAMPP**: [From w3resource](https://www.w3resource.com/php/installation/install-wamp.php).

<br /><br />

# Credits

This repository is a clone of one of the many existing boilerplates created by [Claudio Onoue](https://github.com/claudioonoue) and [Gabriel Oliveira](https://github.com/gaoliveira21).

Made with ❤ and a little bit of Markdown.