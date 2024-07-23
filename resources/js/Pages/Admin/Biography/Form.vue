<template>
    <modal :show="show" @close="show = !show">
        <form @submit.prevent="submit" method="POST">
            <h3 class="harrison text-center">{{ title }}</h3>

            <div class="control">
                <label for="year">Année</label>
                <input type="text" id="year" v-model="event.year" required>
                <jet-input-error :message="event.error('year')" class="mt-2" />
            </div>

            <div class="control">
                <label for="text_fr">Texte (fr)</label>
                <textarea id="text_fr" rows="5" v-model="text_fr" placeholder="Sauter une ligne pour séparer les informations" required></textarea>
                <jet-input-error :message="event.error('text_fr')" class="mt-2" />
            </div>

            <div class="control">
                <label for="text_en">Texte (en)</label>
                <textarea id="text_en" rows="5" v-model="text_en" placeholder="Sauter une ligne pour séparer les informations" required></textarea>
                <jet-input-error :message="event.error('text_en')" class="mt-2" />
            </div>

            <div class="actions">
                <button type="submit">Enregistrer</button>
            </div>
        </form>
    </modal>
</template>

<script>
import Modal from "@/Jetstream/Modal";
import JetInputError from '@/Jetstream/InputError'
import EventBus from "@/Mixins/event-bus";
import Form from "@/Pages/Admin/Music/Form";
export default {
    components: {
        Modal,
        JetInputError,
    },

    props: ['edition'],

    data () {
        return {
            show: false,
            edit: false,

            text_fr: '',
            text_en: '',
            event: this.$inertia.form({
                year: '',
            })
        }
    },

    mounted () {
        EventBus.$on('showDateForm', () => {
            this.show = true
            this.edit = false
        });

        EventBus.$on('editDateForm', (data) => {
            this.show = true;
            this.edit = true;
            this.event = this.$inertia.form({
                ...data
            });
            ['fr', 'en'].forEach((l) => this[`text_${l}`] = this.event.text[l])
        })
    },

    methods: {
        submit () {
            let formData = new FormData();
            formData.append('year', this.event.year);
            formData.append('text_fr', this.text_fr);
            formData.append('text_en', this.text_en);
            const path = this.edit ? `/admin/biographie/${this.event.id}` : '/admin/biographie'
            this.$inertia.post(path, formData, {
                onSuccess: () => {
                    this.event.reset();
                    this.show = false;
                    this.edit = false;
                }
            })
        },
    },

    computed: {
        title () {
            return this.edit ? `Modifier l'annee ${this.event.year}` : 'Nouvelle date'
        }
    }
}
</script>
