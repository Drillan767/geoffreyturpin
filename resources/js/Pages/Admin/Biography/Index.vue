<template>
    <app-layout>
        <template #header>
            Biographie
        </template>

        <div class="py-12 admin_music">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-center">
                            <button @click="showForm">+ Nouvelle date</button>
                        </div>

                        <section class="text-gray-700 body-font">
                            <div class="container px-5 py-12 mx-auto">
                                <div class="flex flex-wrap -m-4">
                                    <div class="xl:w-1/4 md:w-1/2 w-full p-2 date" v-for="(event, i) in $page.events" :key="i">
                                        <div class="flex flex-col p-6 rounded-lg text-center shadow h-full">
                                            <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ event.year }}</h2>
                                            <p class="leading-relaxed text-base">
                                                {{ truncate(event.text.fr) }}
                                            </p>
                                            <div class="flex justify-between mt-auto buttons">
                                                <button @click="editForm(event)">Modifier</button>
                                                <button @click="remove(event)">Supprimer</button>
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
        <DeleteDate />
    </app-layout>
</template>

<script>
import EventBus from '@/Mixins/event-bus';
import Form from './Form';
import AppLayout from '@/Layouts/AppLayout';
import DeleteDate from "@/Pages/Admin/Biography/DeleteDate";

export default {
    components: {
        DeleteDate,
        AppLayout,
        Form,
    },

    mounted () {
        EventBus.$on('appendDate', (payload) => {
            this.$page.dates.push(payload);
        })
    },

    methods: {
        showForm () {
            EventBus.$emit('showDateForm')
        },

        editForm (music) {
            EventBus.$emit('editDateForm', music)
        },

        remove (music) {
            EventBus.$emit('deleteDateForm', music)
        },

        truncate (str) {
            return str.length < 90 ? str : `${str.substr(0, str.substr(0, 87 ).lastIndexOf(' '))}...`
        }
    }
}
</script>
