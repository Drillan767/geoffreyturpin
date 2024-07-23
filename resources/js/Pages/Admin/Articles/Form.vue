<template>
    <form @submit.prevent="submit">
        <div class="flex items-center text-white px-6 py-4 border-0 relative mb-4 bg-blue-500" v-if="$page.message">
            <span class="text-xl inline-block mr-5 align-middle">
                <i class="fas fa-info-circle"></i>
            </span>
            <span class="inline-block align-middle mr-8">
                {{ $page.message }}
            </span>
        </div>
        <Label value="En quelle langue sera l'article ?" class="text-center mb-4" />
        <div class="flex justify-evenly">
            <checkblock
                v-for="(l) in ['en', 'fr']"
                :parent="article.lang"
                :value="l"
                :display="lang[l]"
                @change="changeLanguage(l)"
                :key="l"
            />
        </div>

        <div v-if="article.lang !== ''">
            <div class="control">
                <Label value="Titre" />
                <input type="text" v-model="article.title" required />
                <input-error :message="article.error('title')" class="mt-2" />
            </div>

            <div class="control photo">
                <Label value="Illustration" />
                <img :src="article.illustration" v-if="! preview && article.illustration" alt="illustration" class="first">
                <img :src="preview" v-if="preview" alt="illustration" class="second">
                <input type="file" class="hidden" ref="photo" @change="updatePhotoPreview" />
                <button @click.prevent="selectNewPhoto">
                    <i class="fas fa-upload mr-4"></i>
                    Selectionner un fichier...
                </button>
                <input-error :message="article.error('illustration')" class="mt-2" />
            </div>

            <div class="control">
                <Label value="Tags" />
                <div class="flex items-center">
                    <multi-select
                        :options="tags"
                        v-model="article.tags"
                        tag-placeholder="Ajouter ceci comme nouveau tag"
                        placeholder="Chercher un tag"
                        label="name"
                        track-by="id"
                        :multiple="true"
                        :taggable="true"
                    />
                    <button @click.prevent="tagModal" class="ml-2 flex-superior">Gérer les tags</button>
                </div>
                <input-error :message="article.error('tags')" class="mt-2" />
            </div>

            <div class="control">
                <Label value="Contenu" />
                <Wysiwyg v-model="article.content" :tiny_secret="$page.tiny_secret" @upload="handleUpload" />
                <input-error :message="article.error('content')" class="mt-2" />
            </div>

            <div class="actions">
                <button type="submit" @click="article.draft = true" class="cancel">Enregistrer comme brouillon</button>
                <button type="submit" @click="article.draft = false">Enregistrer et publier</button>
            </div>
        </div>
        <TagHandler @updateTags="changeLanguage(article.lang)" />
    </form>
</template>

<script>
import EventBus from "@/Mixins/event-bus";
import Checkblock from "@/Jetstream/Checkblock";
import Label from "@/Jetstream/Label";
import InputError from "@/Jetstream/InputError";
import Wysiwyg from "@/Jetstream/Wysiwyg";
import MultiSelect from 'vue-multiselect';
import TagHandler from "@/Pages/Admin/Articles/TagHandler";
export default {
    components: {
        TagHandler,
        Wysiwyg,
        Checkblock,
        Label,
        InputError,
        MultiSelect
    },

    props: ['edit', 'translate'],

    data() {
        return {
            preview: '',
            submitURL: '/admin/article',
            tags: [],
            contentFiles: [],
            contentPreview: [],

            lang: {
                fr: 'Français',
                en: 'Anglais',
            },

            article: this.$inertia.form({
                lang: '',
                tags: [],
                title: '',
                illustration: '',
                content: '',
                draft: false,
            })
        }
    },

    mounted () {

        if (this.edit) {
            this.article = this.$inertia.form({
                ...this.$page.article
            })

            if (this.translate) {
                this.article.lang = this.article.default_lang === 'fr' ? 'en' : 'fr';
            } else {
                this.article.lang = this.article.default_lang;
            }
            this.changeLanguage(this.article.lang);

            this.article.title = this.article.title[this.article.lang];
            this.article.content = this.article.content[this.article.lang]
            this.article.tags = this.article.tags.map(tag => {
                return {id: tag.id, name: tag.name[this.article.lang]}
            })

            this.submitURL = `/admin/article/${this.article.id}`
        }
    },

    methods: {
        submit () {
            let formData = new FormData();
            formData.append('title', this.article.title)
            formData.append('tags', JSON.stringify(this.article.tags))
            formData.append('lang', this.article.lang)
            formData.append('illustration', this.$refs.photo.files[0])
            formData.append('draft', this.article.draft ? '1' : '0')
            formData.append('content', this.article.content)
            if (this.edit) {
                formData.append('editing', 'true')
            }
            if (this.translate) {
                formData.append('translating', 'true')
            }
            this.contentFiles.forEach((file) => {
                formData.append('content_files[]', file)
            })
            formData.append('content_preview', JSON.stringify(this.contentPreview));

            this.$inertia.post(this.submitURL, formData)
        },

        changeLanguage (l) {
            this.article.lang = l;
            axios.get(`/admin/tags/${l}`)
                .then((data) => {
                    this.tags = data.data.map((tag) => {
                        return {id: tag.id, name: tag.name}
                    });
                })
        },

        publish (value) {
            this.article.draft = value;
        },

        updatePhotoPreview () {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.preview = e.target.result;
            };

            reader.readAsDataURL(this.$refs.photo.files[0]);
        },

        selectNewPhoto () {
            this.$refs.photo.click();
        },

        addTag (newTag) {
            const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000)),
            }

            this.tags.push(tag);
            this.article.tags.push(tag)
        },

        handleUpload (file) {
            const { image, uuid } = file
            this.contentFiles.push(image);
            this.contentPreview.push(uuid);
        },

        tagModal () {
            EventBus.$emit('handleTags');
        }
    }
}
</script>
