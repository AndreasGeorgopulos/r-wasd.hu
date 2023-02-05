<script async="async">
    window.addEventListener("load", function(){
        window.cookieconsent.initialise({
            "palette": {
                "popup": {
                    "background": "{{config('app.cookie-consent.palette.popup.background')}}",
                    "text": "{{config('app.cookie-consent.palette.popup.text')}}",
                },
                "button": {
                    "background": "{{config('app.cookie-consent.palette.button.background')}}",
                    "text": "{{config('app.cookie-consent.palette.button.text')}}",
                }
            },
            "theme": "classic",
            "content": {
                "message": "{{config('app.cookie-consent.content.message')}}",
                "dismiss": "{{config('app.cookie-consent.content.dismiss')}}",
                "link": "{{config('app.cookie-consent.content.link')}}",
                "href": "{{config('app.cookie-consent.content.href')}}"
            }
        })});
</script>
