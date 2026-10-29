# Fælles AI-arbejdsmetode — projektovergribende

Denne tekst gælder som udgangspunkt for projekter, der har valgt at bruge den. **Projektets egne aktuelle instruktioner, godkendelser, platform og sikkerhedskrav har forrang ved konflikt.** Kopiér ikke projekt- eller kundespecifikke regler til andre projekter.

## Før arbejdet
- Hent og læs seneste projektinstruktioner fra den aktuelle hovedbranch. Brug aldrig en forældet kopi.
- Find eksisterende opgave/status og genbrug dokumentation, løsninger og relevante adgange, før nyt arbejde oprettes.
- Skeln mellem idéer/forslag og godkendt implementering. Gå i gang ved en konkret bestilling som "lav det", uden unødige gentagne tilladelser.
- Bevar nyere ændringer fra andre tråde eller bidragydere.

## Udfør og verificér
- Brug den enkleste tilstrækkelige løsning og genbrug det, der allerede virker.
- Vælg **mindste nødvendige kontrolomfang** efter risiko: enkelt indhold/design, ændret funktion eller kritisk adgang/data/økonomi.
- Test kun berørte funktioner og reelle afhængigheder; gentag ikke beståede kontroller for præcis samme version uden konkret grund.
- Omgå aldrig obligatoriske CI-gates, autorisation, databeskyttelse eller projektets udgivelsesprocedure.
- Rapportér kort resultat, eventuelle blokkere og om det er klar til udgivelse; påstå aldrig en gennemført udgivelse uden bekræftelse.

## Overdragelse og læring
- Hold et kort checkpoint for større opgaver: **færdigt, mangler, næste skridt, branch/PR eller fil, ikke udgivet/live og blokkere**.
- Ved afslutning: vurder, om ny læring er en **permanent arbejdsregel**, **genbrugelig faglig viden** eller **kun konkret opgavehistorik**.
- Opdatér eksisterende relevant regel- eller vidensfil ved varig læring, frem for at oprette dubletdokumenter.
- Gem ikke kundedata, hemmeligheder eller flygtige målinger i fælles arbejdsregler.
- Ændringer af dette fælles regelsæt skal vurderes i hvert projekts kontekst, før de udrulles. **Der sker ingen automatisk synkronisering mellem repositorier.**

Lokalt projekt: `tommyfjepsen/fvbapp`.

Kilde til fælles principper: `tommyfjepsen/constitus-hub-portal/docs/agents/shared-ai-workflow.md`. Den lokale projektkopi er fortsat gældende, indtil den opdateres i det pågældende projekt.
