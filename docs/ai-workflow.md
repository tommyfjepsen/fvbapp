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

## Overtagelse af fastlåst eller utilgængelig ChatGPT-tråd

Når brugeren beder en ny tråd overtage en fastlåst, udløbet eller utilgængelig tråd:

1. Hent seneste `AGENTS.md` og de relevante projekt- og vidensfiler fra hovedbranchen. Brug aldrig en gammel lokal kopi.
2. Find eksisterende GitHub-issue/checkpoint, aktive branches/PR'er og eventuelle relevante release- eller integrationsstatusser.
3. Kontrollér, hvad der faktisk er udført, hvad der mangler, og om noget er udgivet. En gammel chats seneste besked er ikke bevis på status.
4. Fortsæt det **eksisterende** arbejde fra verificeret tilstand. Opret ikke parallelle issues, branches, løsninger eller Work-tråde, hvis de allerede findes. Bevar nyere ændringer fra andre tråde.
5. Opdatér det eksisterende checkpoint med **færdigt, mangler, næste skridt, branch/PR, udgivelsesstatus og konkrete blokkere**.
6. Meld kort til brugeren, at overtagelsen er sket, hvad næste skridt er, og hvilke oplysninger der eventuelt ikke kunne genskabes. Bed kun om nødvendige manglende oplysninger.

En ny tråd må ikke antage, at den kan læse eller styre den gamle ChatGPT-tråd. Brug tilgængelige projektkilder frem for at gætte. Overtagelse er ikke en ny tilladelse til at udgive; følg projektets gældende releaseprocedure.
