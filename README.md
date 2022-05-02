# Finite State Machines Experiment

## Installation

1. Download [Composer](https://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephp/app [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist cakephp/app
```

In case you want to use a custom app dir name (e.g. `/myapp/`):

```bash
composer create-project --prefer-dist cakephp/app myapp
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 8765
```

Then visit `http://localhost:8765` to see the welcome page.

## Enpoints

### List
```
GET /machines
```

Returns the machines saved in the session.

### Add
```json
POST /machines/create

{
  "states": ["awake", "sleeping", ...],
  "transitions": ["08:00", "12:00", ...],
}
```

Adds a machine to the session. The new machine is returned in the response.

### Change machine state
```json
POST /machines/transit/:id

{
  "state": "awake"
}

OR

{
    "transition": "08:00"
}
```

If you only send the state, the application will return the machine's possible transitions;
If you send a valid transition, the application will update the machine state.

### Remove
```json
DELETE /machines/remove/:id
```

Will delete the desired machine.
