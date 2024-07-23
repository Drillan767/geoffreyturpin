<template>
    <app-layout>
        <template #header>
            Articles
        </template>

        <div class="py-12 admin_article">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="text-white px-6 py-4 border-0 relative mb-4 bg-green-500" v-if="$page.flash.success">
                            <span class="text-xl inline-block mr-5 align-middle">
                                <i class="fas fa-check"></i>
                            </span>
                            <span class="inline-block align-middle mr-8">
                                {{ $page.flash.success }}
                            </span>
                        </div>
                        <div class="flex justify-center">
                            <inertia-link :href="route('articles.create')">+ Nouvel article</inertia-link>
                        </div>

                        <section class="text-gray-700 body-font">
                            <div class="container px-5 py-12 mx-auto">
                                <div class="flex flex-wrap -m-4">
                                    <div class="flex flex-col w-full">
                                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                                <div class="shadow overflow-hidden border-b border-gray-200">
                                                    <table class="min-w-full divide-y divide-gray-200">
                                                        <thead class="bg-black">
                                                        <tr>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                                Titre
                                                            </th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                                Statut
                                                            </th>
                                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                                                Traduction
                                                            </th>
                                                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">
                                                                Actions
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody class="bg-white divide-y divide-gray-200">
                                                        <tr v-for="(article,i) in $page.articles" :key="i">
                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <div class="text-sm text-gray-900">{{ article.title[article.default_lang] }}</div>
                                                                <div class="text-sm text-gray-500">
                                                                    <span v-for="(tag, i) in article.tags" :key="tag.id">
                                                                        {{ tag.name[article.default_lang] }}
                                                                        <span v-if="i !== article.tags.length -1" class="mr-1">, </span>
                                                                    </span>
                                                                </div>
                                                            </td>

                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                <span
                                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                                                    :class="{'bg-green-100 text-green-800': !article.draft, 'bg-orange-100 text-orange-800': article.draft }" >
                                                                    {{ article.draft ? 'Brouillon' : 'Publié' }}
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                 <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                                     {{ displayTranslation(article) }}
                                                                </span>
                                                            </td>
                                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                                <inertia-link
                                                                    :href="`/admin/article/${article.id}/modifier`"
                                                                    class="text-indigo-600 hover:text-indigo-900"
                                                                >
                                                                    Modifier
                                                                </inertia-link>
                                                                <span>|</span>
                                                                <inertia-link
                                                                    :href="`/admin/article/${article.id}/traduire`"
                                                                    class="text-indigo-600 hover:text-indigo-900"
                                                                >
                                                                    {{ displayTranslationEdition(article) }}
                                                                </inertia-link>
                                                                <span>|</span>
                                                                <span class="text-red-600 hover:text-red-900 cursor-pointer" @click="deleteForm(article)">
                                                                    Supprimer
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
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
        <DeleteForm />
    </app-layout>
</template>

<script>
import EventBus from '@/Mixins/event-bus';
import AppLayout from "@/Layouts/AppLayout";
import DeleteForm from "@/Pages/Admin/Articles/DeleteForm";

export default {
    title: 'Index des articles',

    components: {
        AppLayout,
        DeleteForm,
    },

    methods: {
        deleteForm (article) {
            EventBus.$emit('deleteArticle', article);
        },

        displayTranslation (article) {
            const translated = JSON.parse(article.translated);
            const langs = {fr: 'Français', en: 'English'}
            if (translated.length > 1) {
                return 'Complète'
            } else {
                return langs[translated[0]];
            }
        },

        displayTranslationEdition (article) {
            const translated = JSON.parse(article.translated);
            if (translated.length > 1) {
                return 'Modifier traduction'
            } else {
                return 'Traduire'
            }
        }
    }
}
</script>
