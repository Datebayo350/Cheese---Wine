# Data dictionnary

## Wine

| Name | Description | Type | Comment |
|--|--|--|--|
| id | wine id | int(AI) | - | - |
| name | wine name | varchar(45) | - |
| appellation | wine appelation | varchar(45) | - |
| picture | wine picture | varchar(45) | - |
| description | wine description | text | - |
| type | wine type | varchar(255) | - | 

## Cheese

| Name | Description | Type | Comment |
|--|--|--|--|
| id | cheese id | int(AI) | - |
| name | cheese name | varchar(45) | - |
| milk | milk type | varchar(45) | - |
| picture | cheese picture | varchar(256) | - |
| description | cheese description | text | - |

## User

| Name | Description | Type | Comment |
|--|--|--|--|
| id | user id | int(AI) | - |
| email | user email | varchar(180) | - |
| password | user password | varchar(180) | - |
| name | user name | varchar(45) | - |
| roles | user role | varchar(45) | - |

## Origin

| Name | Description | Type | Comment |
|--|--|--|--|
| id | origin id | int(AI) |-|
| name | origin name | varchar(45) | - |

## UserProposal

| Name | Description | Type | Comment |
|--|--|--|--|
| id | userProposal id | int(AI) |-|
| username | username | varchar(255) | - |
| mainProduct | main product | varchar(255) | - |
| associatedProduct | associated product | varchar(255) | - |