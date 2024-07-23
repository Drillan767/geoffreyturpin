<template>
    <app-layout>
        <template #header>
            Editer "{{ $page.article.title[$page.article.default_lang] }}"
        </template>

        <div class="py-12 admin_article">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <section class="text-gray-700 body-font">
                            <div class="container px-5 py-12 mx-auto">
                                <Form :edit="true" :translate="false" />
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Form from "@/Pages/Admin/Articles/Form";

export default {
    title: 'Nouvel article',

    components: {
        Form,
        AppLayout,
    }
}
</script>
