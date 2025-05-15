<script>
import {defineComponent} from 'vue'
import Guest from "@/Layouts/Guest.vue";
import Container from "@/Layouts/Container.vue";

export default defineComponent({
    name: "TermsAndConditions",
    components: {Container, Guest}
})
</script>

<template>
<Guest>
    <container>
        <div class="border-2 rounded-b-sm">
            <h4>I. Identificazione e informazioni di contatto</h4>
            <p>
                Questo sito web/applicazione è gestito da [La tua azienda]. La nostra sede principale si trova in [Indirizzo dell’azienda]. Potete contattarci scrivendo all’indirizzo commerciale sopra indicato, utilizzando il modulo di contatto del nostro sito web, inviando un’e-mail a [E-mail dell’azienda] o telefonando a [Numero di telefono dell’azienda].
            </p>

            <h4>II. Natura del servizio</h4>
            <p>
                La [tua azienda] fornisce [Descrizione dei servizi offerti dal tuo sito/app].
            </p>

            III. Limitazione di responsabilità
            [In questa sezione è necessario inserire eventuali dichiarazioni che limitano la tua responsabilità. Poiché questi documenti tendono a essere legalmente vincolanti, ti consigliamo di ricorrere a una soluzione professionale]. Il Proprietario non sarà responsabile di alcun danno diretto, indiretto, incidentale, consequenziale o speciale derivante da o in connessione con l’uso dei servizi o del contenuto del sito web.

            IV. Account utente e restrizioni sui contenuti
            [Qui è necessario aggiungere tutte le regole che vuoi predisporre per gli account utente e per il tuo sito. Queste regole possono includere elementi come le restrizioni sui contenuti. Vedi l’esempio riportato di seguito →] Agli utenti è vietato pubblicare o trasmettere attraverso il sito o il servizio [della tua azienda] qualsiasi materiale illegale, dannoso, minaccioso, molesto, diffamatorio, volgare, osceno, sessualmente esplicito, discriminatorio o altrimenti discutibile di qualsiasi tipo, compreso, ma non solo, qualsiasi materiale che incoraggi una condotta che costituirebbe un reato penale, darebbe luogo a responsabilità civile o violerebbe qualsiasi legge locale, statale, nazionale o internazionale.

            ​
            V. Ordine, prezzi, metodi di pagamento e cancellazione
            [Se sul tuo sito vendi prodotti o servizi, devi includere una sezione come questa, che riguarda prezzi, pagamenti e cancellazione degli ordini. Il testo che segue è solo un esempio e dovrà essere personalizzato per adattarsi alla tua situazione particolare e ai requisiti del tuo Paese. Se non sei sicuro di quello che stai facendo, vi suggeriamo caldamente di consultare un professionista legale o di utilizzare un generatore creato da avvocati, come il nostro].

            Gli acquirenti devono avere almeno [limite di età]. Ci riserviamo il diritto di rifiutare il servizio a chiunque per qualsiasi motivo e in qualsiasi momento. I nostri servizi non sono disponibili nelle giurisdizioni in cui sono vietati dalla legge.

            Dopo aver effettuato un ordine, i clienti riceveranno un’e-mail di conferma con il dettaglio dei prodotti ordinati e del costo totale. [La tua azienda] si riserva il diritto di annullare un ordine in qualsiasi momento prima della spedizione, in caso di circostanze impreviste.

            Accettiamo i seguenti metodi di pagamento: [Visa, MasterCard, e PayPal].

            Tutti i prezzi sono soggetti a modifiche senza preavviso.

            I [prodotti/servizi] acquistati da [La tua azienda] saranno [es. spediti entro tre giorni lavorativi dall’ordine e consegnati entro 5-7 giorni lavorativi]. Effettuiamo consegne in [es. tutta Europa / solo in Italia / tutto il mondo].

            I clienti possono annullare l’ordine entro [durata, ad esempio 24 ore] dall’effettuazione dello stesso, a condizione che l’ordine non sia ancora stato spedito. Per annullare un ordine, il cliente deve [ad esempio, accedere alla sezione dedicata del proprio account e richiedere l’annullamento].

            VI. Informazioni sulla garanzia
            [Se vendi prodotti o servizi sul vostro sito, devi includere anche informazioni sui diritti di garanzia, come richiesto dalle leggi sui consumatori di alcuni Paesi].

            Tutti i prodotti offerti da [la tua azienda] sono coperti da una garanzia standard [durata della garanzia, ad es. 24 mesi] che copre i difetti di [es. materiale, lavorazione]. Questa garanzia non copre [elencare tutte le condizioni necessarie, ad esempio uso improprio, modifiche non autorizzate o cause naturali].

            VII. Diritto di recesso
            [Se vendi prodotti o servizi sul tuo sito, dovrai includere anche i dettagli sui diritti di recesso, come richiesto dalle leggi sui consumatori di alcuni paesi].

            I clienti hanno il diritto di recedere dal contratto entro [durata, ad esempio 14 giorni] senza fornire alcuna motivazione. Il periodo di recesso scadrà dopo [durata, ad esempio 14 giorni] dal giorno in cui il cliente acquisisce, o un terzo diverso da [ad esempio il vettore] e indicato dal cliente acquisisce, [ad esempio il “possesso fisico dei beni”].

            VIII. Informazioni sulla sicurezza e istruzioni per l’uso
            I nostri [prodotti/servizi] devono essere utilizzati in conformità alle istruzioni e alle linee guida fornite. In caso contrario, si possono verificare [ad esempio, “lesioni”, “Assicurarsi sempre che il prodotto sia assemblato correttamente prima dell’uso e tenerlo lontano dalla portata dei bambini”].

            ​
            Utilizzando il sito web/applicazione [della tua azienda], accettate di rispettare i presenti Termini e Condizioni. L’uso continuato del sito web/applicazione dopo la pubblicazione delle modifiche implica l’accettazione di essere legalmente vincolati da questi termini aggiornati e/o modificati.
        </div>
    </container>
</Guest>
</template>

<style scoped>

</style>
