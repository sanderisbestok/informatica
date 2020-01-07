### How to git 
Als je aan iets nieuws gaat werken:

```bash
$ git checkout dev && git pull
$ git branch NAAM_BRANCH
```

Nu kan je van alles gaan doen in je eigen branch, zodra een commit sense maakt deze doen met een duidelijk commit message. Dus niet vier dingen in 1 commit, gewoon unstagen als iets nog niet af is maar iets anders al wel
Als je branch lang loopt (meerdere pushes naar dev), neem dan even de tijd om dit terug te mergen in jouw branch (doe dit alleen nadat je een commit hebt gedaan):

```bash
$ git checkout dev && git pull && git checkout NAAM_BRANCH
$ git merge --no-commit dev
```

Kijk nu even wat er gewijzigd is, zeker als er conflicts zijn. In dat geval moet je de juiste wijzigingen handmatig toevoegen en/of stagen. Als er iets is veranderd wat impact heeft op jouw werk, pas dat dan nu aan. Als alles is verwerkt kan je een commit doen, dan ben je weer in sync met iedereen.

```bash
$ git commit
```

Als je werk klaar is, preferably met dev teruggemerged en getest dat het compileert, runt en doet wat het moet doen, push je het naar de remote;

```bash
$ git push origin NAAM_BRANCH
```

Hierna kan je een merge request indienen op GitLab. Als er dingen zijn gewijzigd waar stappen voor vereist zijn voor de andere developers voeg deze dan toe aan de README. Vergeet ook de gitignore niet aan te passen als je nieuwe bestanden/types hebt geintroduceerd. Bas gaat er dan naar kijken en eventueel vragen of je nog iets wil aanpassen. Ondertussen kan je gewoon verder werken aan een andere branch. Als je toch nog in dezelfde branch wil/moet werken, laat Bas dit dan weten anders heeft het geen zin om verder te gaan met de merge.

Zodra het in dev staat krijg je hier een notificatie van in #git en op GitLab. Dan moet je het nog even testen met dev. Als er iets nog niet kan je even met Bas overleggen hoe we dit het beste fixen.
