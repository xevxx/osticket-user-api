# API extension for osticket - tested against 1.12 (tested json only)
## Create and register client users or update client users programatically

osticket: https://github.com/osTicket

Initial code and idea taken from user on osticket forum: NotionCommotion

https://forum.osticket.com/d/93191-do-users-need-to-be-registered-if-they-use-the-api-to-add-tickets

API endpoint is secured using standard osticket API process

https://docs.osticket.com/en/latest/Developer%20Documentation/API%20Docs.html

## What to do
Add user.api.php to include folder

Amend http.php to api folder adding two lines:
```
 url_post("^/users\.(?P<format>xml|json|email)$", array('api.users.php:UsersApiController','create')),
 url_post("^/userscp\.(?P<format>xml|json|email)$", array('api.users.php:UsersApiController','changepword')),
```
after
```
url_post("^/tickets\.(?P<format>xml|json|email)$", array('api.tickets.php:TicketApiController','create')),
```

### http://osticketurl/api/users.json //create and register user endpoint
post JSON object in format:
```
{
  "name": "user name",
  "email": "email address",
  "passwd1": "password"
}
```

### http://osticketurl/api/userscp.json //update user passwrord endpoint
post JSON object in format:
```
{
	"email": "user email address",
	"passwd1": "new password"
}
```
