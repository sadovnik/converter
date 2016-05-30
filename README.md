[![Build Status](https://travis-ci.org/codeskull/converter.svg?branch=master)](https://travis-ci.org/codeskull/converter) [![Code Climate](https://codeclimate.com/github/codeskull/converter/badges/gpa.svg)](https://codeclimate.com/github/codeskull/converter)
[![Test Coverage](https://codeclimate.com/github/codeskull/converter/badges/coverage.svg)](https://codeclimate.com/github/codeskull/converter/coverage)

## About
A converter for config-related text formats. Supported formats:
- json
- ini
- yaml

## Install
```
sudo git clone https://github.com/codeskull/converter /opt/converter # pull the repo
ln -s /opt/converter/bin/convert /usr/local/bin/convert # link the binary
```

## Usage example
`convert from.json to.yml`

## Requirments
- PHP 5.6+
- [Yaml extention](http://php.net/manual/en/book.yaml.php)
