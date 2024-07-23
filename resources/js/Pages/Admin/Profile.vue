<template>
    <app-layout>
        <template #header>
            Profil
        </template>

        <div class="py-12">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="text-white px-6 py-4 border-0 relative mb-4 bg-green-500" v-if="success">
                                <span class="text-xl inline-block mr-5 align-middle">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="inline-block align-middle mr-8">
                                    Informations enregistrées avec succès.
                                </span>
                            </div>
                            <div class="control">
                                <label for="email">Adresse email</label>
                                <input id="email" type="email" v-model="user.email" required />
                                <jet-input-error :message="user.error('email')" class="mt-2" />
                            </div>

                            <div class="control photo">
                                <img :src="user.picture" v-if="! preview && user.picture" alt="profile" class="first">
                                <img :src="preview" v-if="preview" alt="profile" class="second">
                                <input type="file" class="hidden" ref="photo" @change="updatePhotoPreview" />
                                <button @click.prevent="selectNewPhoto">
                                    <i class="fas fa-upload mr-4"></i>
                                    Selectionner un fichier...
                                </button>
                            </div>

                            <div class="control">
                                <label for="description_fr">Description (fr)</label>
                                <textarea id="description_fr" cols="30" rows="10" v-model="description_fr" required></textarea>
                                <jet-input-error :message="user.error('description_fr')" class="mt-2" />
                            </div>

                            <div class="control">
                                <label for="description_en">Description (en)</label>
                                <textarea id="description_en" cols="30" rows="10" v-model="description_en" required></textarea>
                                <jet-input-error :message="user.error('description_en')" class="mt-2" />
                            </div>

                            <div class="control">
                                <label for="youtube">Youtube</label>
                                <input type="text" id="youtube" v-model="user.youtube" required />
                                <jet-input-error :message="user.error('youtube')" class="mt-2" />
                            </div>

                            <div class="control">
                                <label for="linkedin">LinkedIn</label>
                                <input type="text" id="linkedin" v-model="user.linkedin" required />
                                <jet-input-error :message="user.error('linkedin')" class="mt-2" />
                            </div>

                            <div class="control">
                                <label for="facebook">Facebook</label>
                                <input type="text" id="facebook" v-model="user.facebook" required />
                                <jet-input-error :message="user.error('facebook')" class="mt-2" />
                            </div>

                            <hr />

                            <div class="control">
                                <label for="password">Nouveau mot de passe</label>
                                <input type="password" id="password" v-model="user.password" />
                                <jet-input-error :message="user.error('password')" class="mt-2" />
                            </div>

                            <div class="control">
                                <label for="password_confirmation">Confirmer le mot de passe</label>
                                <input type="password" id="password_confirmation" v-model="user.password_confirmation" />
                            </div>

                            <div class="actions">
                                <button type="submit">
                                    Enregistrer
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import JetInputError from '@/Jetstream/InputError'

export default {
    components: {
        AppLayout,
        JetInputError,
    },

    data () {
        return {
            preview: '',
            description_fr: '',
            description_en: '',
            success: false,

            user: this.$inertia.form({
                picture: '',
                description: '',
                email: '',
                facebook: '',
                linkedin: '',
                youtube: '',
                password: '',
                password_confirmation: '',
            })
        }
    },

    mounted () {
        this.user = this.$inertia.form({
            ...this.$page.user
        });

        ['en', 'fr'].forEach(l => this[`description_${l}`] = this.user.description[l]);
    },

    methods: {
        submit () {
            let formData = new FormData();
            ['email', 'facebook', 'linkedin', 'youtube', 'password', 'password_confirmation'].forEach((field) => {
                formData.append(field, this.user[field])
            });

            formData.append('description_fr', this.description_fr);
            formData.append('description_en', this.description_en);
            formData.append('picture', this.$refs.photo.files[0])
            this.$inertia.post('/admin', formData, {
                preserveScroll: true,
                onSuccess: () => {
                    window.scrollTo({top: 0, behavior: 'smooth'});
                    this.success = true;
                }
            })
            this.$inertia.on('error', (e) => console.log(e))
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
        }
    }
}
</script>
