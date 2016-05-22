[![Build Status](https://travis-ci.org/codeskull/converter.svg?branch=master)](https://travis-ci.org/codeskull/converter)

## About
A converter for config-related text formats. Supported formats:
- json
- ini
- yaml

## Install
```
sudo git clone https://github.com/codeskull/converter /opt/converter # pull the repo
ln -s /opt/converter/convert.sh /usr/local/bin/convert # link the binary
```

## Usage example
`convert from.json to.yml`

## Requirments
- PHP 5.6+
- [Yaml extention](http://php.net/manual/en/book.yaml.php)
