<template>
    <modal :show="show" @close="show = !show">
        <form @submit.prevent="submit" method="POST">
            <h3 class="harrison text-center">{{ title }}</h3>
            <div class="control">
                <label for="title">Titre</label>
                <input type="text" id="title" v-model="music.title" required>
                <jet-input-error :message="music.error('title')" class="mt-2" />
            </div>

            <div class="control">
                <label for="author">Auteur</label>
                <input type="text" id="author" v-model="music.author" required>
                <jet-input-error :message="music.error('author')" class="mt-2" />
            </div>

            <div class="control">
                <label for="year">Année</label>
                <input type="text" id="year" v-model="music.year" required>
                <jet-input-error :message="music.error('year')" class="mt-2" />
            </div>

            <div class="control">
                <label for="subtitle">Sous-titre</label>
                <input type="text" id="subtitle" v-model="music.subtitle">
                <jet-input-error :message="music.error('subtitle')" class="mt-2" />
            </div>

            <div class="control">
                <label for="content_fr">Texte (fr)</label>
                <textarea id="content_fr" rows="5" v-model="content_fr" placeholder="Sauter une ligne pour séparer les informations" required></textarea>
                <jet-input-error :message="music.error('content_fr')" class="mt-2" />
            </div>

            <div class="control">
                <label for="content_en">Texte (en)</label>
                <textarea id="content_en" rows="5" v-model="content_en" placeholder="Sauter une ligne pour séparer les informations" required></textarea>
                <jet-input-error :message="music.error('content_en')" class="mt-2" />
            </div>

            <div class="control">
                <label for="iframe">Vidéo à intégrer</label>
                <textarea id="iframe" rows="5" v-model="music.iframe" required></textarea>
                <jet-input-error :message="music.error('iframe')" class="mt-2" />
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

            content_fr: '',
            content_en: '',
            music: this.$inertia.form({
                title: '',
                author: '',
                year: '',
                subtitle: '',
                content: '',
                iframe: '',
            })
        }
    },

    mounted () {
        EventBus.$on('showMusicForm', () => {
            this.show = true
            this.edit = false
        });

        EventBus.$on('editMusicForm', (data) => {
            this.show = true;
            this.edit = true;
            this.music = this.$inertia.form({
                ...data
            });
            ['fr', 'en'].forEach((l) => this[`content_${l}`] = this.music.content[l])
        })
    },

    methods: {
        submit () {
            let formData = new FormData();
            ['title', 'author', 'year', 'subtitle', 'iframe'].forEach((field) => {
                formData.append(field, this.music[field]);
            })
            formData.append('content_fr', this.content_fr)
            formData.append('content_en', this.content_fr)
            const path = this.edit ? `/admin/music/${this.music.id}` : '/admin/music'
            this.$inertia.post(path, formData, {
                onSuccess: () => {
                    this.music.reset();
                    this.show = false;
                    this.edit = false;
                }
            })
        },
    },

    computed: {
        title () {
            return this.edit ? `Modifier "${this.music.title}"` : 'Nouvelle musique'
        }
    }
}
</script>
