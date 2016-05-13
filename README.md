# Redmine Light 

PHP based command line tool for common tasks in Redmine, can easily be 
extended for your own purposes.

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**  *generated with [DocToc](https://github.com/thlorenz/doctoc)*

- [Configuration](#configuration)
- [Commands available](#commands-available)
  - [Redmine generate sub tickets from json file](#redmine-generate-sub-tickets-from-json-file)
  - [Log time per ticket](#log-time-per-ticket)
- [Example task file](#example-task-file)
- [Todo list](#todo-list)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

## Configuration

Move `config/config.ini.dist` to `config/config.ini` and edit the 
appropriate settings, Token and Host is required fields.  

## Commands available

### Redmine generate sub tickets from json file

```
Usage:
  rl:subs <file>
  
Arguments:
  file                  Please specify the json file
```
  
### Log time per ticket

```
Usage:
   rl:time <ticket> <time> []
 
 Arguments:
   ticket                Ticket number [example: 10000 or #10001]
   time                  Time [example: 1d2h3m or 0.15]
   comment               Custom Comment Auto-log will be over written
```
   

## Example task file

File name does not matter as long as it is in json format

```json
{
  "10000": [
    {
      "task": "Example sub-ticket subject estimate only",
      "time": "9m"
    },
    {
      "task": "Example sub-ticket for #10000 estimate & log time",
      "time": "9m:3m"
    }
  ],
  "10001": [
    {
      "task": "Example sub-ticket for #10001 no time additions"
    }
  ]
}
```

## Todo list

* Change configuration file loader, perhaps move to ~/.redmine-lite.yml
* Remove second ticket getter on successful creation
* Add project listing, user listing and comments on tickets
* Add media inclusion `!media.jpg!` after attachment upload
* Write tests