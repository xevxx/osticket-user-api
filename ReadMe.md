# API extension for osticket - tested against 1.12 (tested json only)


```
http://osticketurl/api/users.json //create and register user endpoint
post JSON object in format:
{
  "name": "user name",
  "email": "email address",
  "passwd1": "password"
}


http://osticketurl/api/userscp.json //update user passwrord endpoint
post JSON object in format:
{
	"email": "user email address",
	"passwd1": "new password"
}


```
