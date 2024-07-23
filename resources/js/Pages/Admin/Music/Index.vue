<template>
    <app-layout>
        <template #header>
            Musiques
        </template>

        <div class="py-12 admin_music">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-center">
                            <button @click="showForm">+ Nouvelle musique</button>
                        </div>

                        <section class="text-gray-700 body-font">
                            <div class="container px-5 py-12 mx-auto">
                                <div class="flex flex-wrap -m-4">
                                    <div class="xl:w-1/4 md:w-1/2 w-full p-2 music" v-for="(music, i) in $page.musics" :key="i">
                                        <div class="flex flex-col p-6 rounded-lg text-center shadow h-full">
                                            <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ music.title }}</h2>
                                            <p class="leading-relaxed text-base">
                                                {{ music.author }}
                                            </p>
                                            <p class="leading-relaxed text-base">
                                                {{ music.year }}
                                            </p>
                                            <div class="flex justify-between mt-auto buttons">
                                                <button @click="editForm(music)">Modifier</button>
                                                <button @click="remove(music)">Supprimer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <Form />
        <DeleteMusic />
    </app-layout>
</template>

<script>
import EventBus from '@/Mixins/event-bus';
import Form from './Form';
import AppLayout from '@/Layouts/AppLayout';
import DeleteMusic from "@/Pages/Admin/Music/DeleteMusic";

export default {
    components: {
        DeleteMusic,
        AppLayout,
        Form,
    },

    methods: {
        showForm () {
            EventBus.$emit('showMusicForm')
        },

        editForm (music) {
            EventBus.$emit('editMusicForm', music)
        },

        remove (music) {
            EventBus.$emit('deleteMusicForm', music)
        }
    }
}
</script>
