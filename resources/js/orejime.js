import Orejime from 'orejime/dist/orejime'

var orejimeConfig = {
    // Optional. You can customize the ID of the <div> that Orejime will create when starting up.
    // The generated <div> will be inserted at the beginning of the <body>.
    // If there is already a DOM element with this id, Orejime will use it instead of creating a new element.
    // defaults to "orejime".
    elementID: "orejime",

    // Optional. For accessibility's sake, the Orejime modal must know what is the element
    // containing your app or website. Orejime should *not* be in this element.
    // The idea is your DOM could look like this after Orejime is initialized:
    // <body>
    //      <div id="orejime">...</div>
    //      <div id="app">your actual website</div>
    // </body>
    //
    // It is highly recommended to set this option, even though it's not required.
    // defaults to undefined.
    appElement: "#app",

    // Optional. You can customize the name of the cookie that Orejime uses for storing
    // user consent decisions.
    // defaults to "orejime".
    cookieName: "orejime",

    // Optional. You can set a custom expiration time for the Orejime cookie, in days.
    // defaults to 365.
    cookieExpiresAfterDays: 365,

    // Optional. You can provide a custom domain for the Orejime cookie, for example to make it available on every associated subdomains.
    cookieDomain: COOKIE_DOMAIN,

    // You must provide a link to your privacy policy page
    privacyPolicy: PRIVACY_POLICY_URL,

    // Optional. Applications configured below will be ON by default if default=true.
    // defaults to true
    default: true,

    // Optional. If "mustConsent" is set to true, Orejime will directly display the consent
    // manager modal and not allow the user to close it before having actively
    // consented or declined the use of third-party apps.
    // defaults to false
    mustConsent: false,

    // Optional. If "mustNotice" is set to true, Orejime will display the consent
    // notice and not allow the user to close it before having actively
    // consented or declined the use of third-party apps.
    // Has no effect if mustConsent is set to true.
    // defaults to false
    mustNotice: false,

    // Optional. You can define the UI language directly here. If undefined, Orejime will
    // use the value given in the global "lang" variable, or fallback to the value
    // in the <html> lang attribute, or fallback to "en".
    lang: "en",

    // Optional. You can pass an image url to show in the notice.
    // If the image is not exclusively decorative, you can pass an object
    // with the image src and alt attributes: `logo: {src: '...', alt: '...'}`
    // defaults to false
    logo: false,

    // Optional. Set Orejime in debug mode to have a few stuff
    // logged in the console, like warning about missing translations.
    // defaults to false
    debug: false,

    // You can overwrite existing translations and add translations for your
    // app descriptions and purposes. See `src/translations.yml` for a full
    // list of translations that can be overwritten
    translations: {
        en: {
            consentModal: {
                description: "This is an example of how to override an existing translation already used by Orejime",
            },
            inlineTracker: {
                description: "Example of an inline tracking script",
            },
            externalTracker: {
                description: "Example of an external tracking script",
            },
            purposes: {
                analytics: "Analytics",
                security: "Security"
            }
        },
    },

    // The list of third-party apps that Orejime will manage for you.
    // The apps will appear in the modal in the same order as defined here.
    apps: [
        {
            // The name of the app, used internally by Orejime.
            // Each name should match a name of a <script> tag defined in the
            // "Changing your existing third-party scripts" documentation step.
            name: "google-tag-manager",

            // The title of you app as listed in the consent modal.
            title: "Google Tag Manager",

            // A list of regex expressions, strings, or arrays, giving the names of
            // cookies set by this app. If the user withdraws consent for a
            // given app, Orejime will then automatically delete all matching
            // cookies.
            //
            // See a different example below with the inline-tracker app
            // to see how to define cookies set on different path or domains.
            cookies: [
                "_ga",
                "_gat",
                "_gid",
                "__utma",
                "__utmb",
                "__utmc",
                "__utmt",
                "__utmz",
                "_gat_gtag_" + GTAG_ID,
                "_gat_" + GTAG_ID
            ],

            // Optional. The purpose(s) of this app. Will be listed on the consent notice.
            // Do not forget to add translations for all purposes you list here.
            purposes: ["analytics"],

            // Optional. A callback function that will be called each time
            // the consent state for the app changes. Passes
            // the `app` config as the second parameter as well.
            callback: function(consent, app){
                // This is an example callback function.
                console.log("User consent for app " + app.name + ": consent=" + consent)
            },

            // Optional. If "required" is set to true, Orejime will not allow this app to
            // be disabled by the user.
            // default to false
            required: false,

            // Optional. If "optOut" is set to true, Orejime will load this app even before
            // the user gave explicit consent.We recommend always leaving this "false".
            // defaults to false
            optOut: false,

            // Optional. If "default" is set to true, the app will be enabled by default
            // Overwrites the global "default" setting.
            // defaults to the value of the gobal "default" setting
            default: true,

            // Optional. If "onlyOnce" is set to true, the app will only be executed
            // once regardless how often the user toggles it on and off.
            // defaults to false
            onlyOnce: true,
        }
    ]
}

const orejime = Orejime.init(orejimeConfig)

if (window.location.hash === '#cookies') {
    orejime.show()
}
