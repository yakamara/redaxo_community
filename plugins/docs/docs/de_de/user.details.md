# User und Gruppen auslesen

Da YCom auf YForm basiert, können auf Details von YCom-Nutzern und Gruppen auf Basis von `rex_sql` oder `YOrm` ausgelesen werden.

## YOrm-Variante (empfohlen)

Siehe auch
* YForm-Dokumentation, Kapitel "YOrm": https://github.com/yakamara/redaxo_yform_docs/blob/master/de_de/yorm.md

**Details des YCom-Nutzers auslesen**
```
$ycom_user = rex_ycom_auth::getUser();

# dump($ycom_user); // auskommentieren, um alle Eigenschaften des Objekts auszugeben

if($ycom_user) {
    echo $ycom_user->getValue('login');             // Benutzer-Login
    echo $ycom_user->getValue('firstname');         // Vorname
    echo $ycom_user->getValue('name');              // Nachname
    echo $ycom_user->getValue('last_action_time');  // Letzte Aktion auf der Seite
    echo $ycom_user->getValue('last_login_time');   // Letzter Login
    echo $ycom_user->getValue('ycom_groups');       // IDs der zugeordneten Gruppen
}
```

> Hinweis: Die Felder lassen sich über den Table Manager in YForm um eigene Felder erweitern.

**Details zur Gruppe eines YCom-Nutzers auslesen**
```
$ycom_user = rex_ycom_auth::getUser();

if($ycom_user) {
        $ycom_group = $ycom_user->getRelatedDataset('ycom_groups');
        $ycom_group->getValue("name"); // Name der Gruppe

        if($ycom_user->isInGroup($group_id)) {
            // User ist in der Gruppe   
        } else {
            // User ist nicht in der Gruppe
        };
}
```

> Hinweis: Die Felder lassen sich über den Table Manager in YForm um eigene Felder erweitern.

**Gruppen-Berechtigung eines YCom-Nutzers auslesen:**

```
$category = rex_category::get($id);
rex_ycom_auth::articleIsPermitted($category); // => true oder false
```
Weitere Methoden der rex_ycom_auth-Klasse: https://github.com/yakamara/redaxo_ycom/blob/master/plugins/auth/lib/ycom_auth.php

## SQL-Variante

Siehe auch: 
* REDAXO API-Dokumentation: https://redaxo.org/api/master/class-rex_sql.html
* Datenbank-Queries in REDAXO 5: https://redaxo.org/doku/master/datenbank-queries

```
$ycom_user = rex_ycom_auth::getUser();

if($ycom_user) {
    $user = $rex_sql::factory()->getArray('SELECT id, name FROM rex_ycom_user WHERE id = :id', [$ycom_user->getId()]);
    # dump($user); // auskommentieren, um alle Schlüssel und Werte des Arrays auszugeben
}
```
