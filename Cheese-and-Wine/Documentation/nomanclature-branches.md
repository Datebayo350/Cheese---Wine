# **Comment se repérer dans la hiérarchie des branches du projet**

## 1) Repérer le nom hiérarchique de la branche

Le nom hiérarchique commence à partir du premier underscor '`_`'

## 2) Que signifie la lettre au début ?

Les branches avec juste une lettre en nom hiérarchique sont des sous-branches directes de 1ère lignée de `Develop` **exemple** : `Back_A`, `Front_B`
Chaque branche enfant de `Develop` se verra attribuer une lettre de l'alphabet, et si jamais celui-ci est atteint on recommance avec une seconde lettre **exemple** : `Feature_AB`

## 3) Que signifie les numéros d'après ?

A l'instar de la branche `Develop`, chaque branche enfant à partir de la  seconde lignée se verra attribuer un chiffre/nombre. Par **exemple**: la branche `API-BackOffice_A_1`, correspondra à la sous-branche enfant n° 1 de `Back_A`. `FOO_A_2` à sa branche n°2, et ainsi de suite.

