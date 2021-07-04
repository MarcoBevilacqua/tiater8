@component('vendor.mail.html.message')
    
# Completa il tuo tesseramento!

Ciao, per velocizzare il tuo tesseramento alla piccola compagnia impertinente ti preghiamo di fornirci alcune informazioni. <br >
Cliccando sul link qui sotto sarai reindirizzato ad un form da completare con i tuoi dati. 

Con questo piccolo passaggio potrai risparmiare del tempo prezioso e aiutarci nella compilazione del tuo modulo. 

@component('vendor.mail.html.button', ['url' => $url, 'color' => 'success'])
Completa la tua iscrizione
@endcomponent


Grazie,<br>
piccola compagnia impertinente
@endcomponent
