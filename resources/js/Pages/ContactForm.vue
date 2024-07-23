<template>
    <form @submit.prevent="submit">
        <div class="success" v-if="sucess">
            <p>{{ translation.success }}</p>
        </div>

        <div class="errors" v-if="errors">
            <ul v-for="(prop, key) in errors" :key="key">
                <li v-for="(error, i) in prop" :key="i">
                    {{ error }}
                </li>
            </ul>
        </div>

        <div class="control">
            <input type="text" v-model="contact.name" :placeholder="translation.name" required />
        </div>
        <div class="control">
            <input type="email" v-model="contact.email" :placeholder="translation.email" required />
        </div>

        <div class="control">
            <input type="text" v-model="contact.subject" :placeholder="translation.subject" required />
        </div>

        <div class="control">
            <textarea cols="30" rows="5" :placeholder="translation.message" v-model="contact.message" required></textarea>
        </div>

        <div class="actions">
            <button type="submit">{{ translation.send }}</button>
        </div>
    </form>
</template>

<script>
import Vue from "vue";
import { VueReCaptcha } from "vue-recaptcha-v3";
Vue.use(VueReCaptcha, { siteKey: '6LfgCtwZAAAAAE9OgFEquH7if5ty6XqHPqj_j_RE' });

export default {
    components: {
        VueReCaptcha,
    },
    data () {
        return {
            sucess: false,
            errors: null,

            contact: {
                name: '',
                email: '',
                subject: '',
                message: '',
                token: '',
            },

            translation: {
                name: '',
                email: '',
                subject: '',
                message: '',
                send: '',
                success: '',
            }
        }
    },

    methods: {
        submit () {
            this.$recaptcha('login')
                .then((token) => {
                    this.contact.token = token;
                    const self = this;
                    axios.post('/contact', this.contact)
                        .then(() => {
                            this.sucess = true;
                            this.contact = {
                                name: '',
                                email: '',
                                subject: '',
                                message: '',
                                token: '',
                            }
                        })
                        .catch((e) => {
                            console.log(e.response);
                            this.errors = e.response.data.errors;
                        })
                });

        }
    },

    mounted () {
        if (document.documentElement.lang === 'fr') {
            this.translation = {
                name: 'Nom',
                email: 'Adresse e-mail',
                subject: 'Objet',
                message: 'Tapez votre message...',
                send: 'Envoyer',
                success: 'Votre message a bien été envoyé !'
            }
        } else {
            this.translation = {
                name: 'Name',
                email: 'Email address',
                subject: 'Subject',
                message: 'Type your message...',
                send: 'Send',
                success: 'Your message was sent successfully!'
            }
        }
    }
}
</script>
