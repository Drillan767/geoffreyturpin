<template>
    <modal :show="show" @close="show = !show" class="delete_modal">
        <h3 class="harrison text-center mb-4">Attention</h3>
        <p>L'article intitulé <b>"{{ article.title[article.default_lang] }}"</b> est sur le point d'être supprimé, ainsi que ses images et ses traductions.
            Cette opération est irréversible. <br /><br /> Continuer ?</p>

        <div class="actions flex justify-end">
            <button @click="show = !show">Annuler</button>
            <button class="danger" @click="submit">Supprimer</button>
        </div>
    </modal>
</template>

<script>
import EventBus from '@/Mixins/event-bus';
import Modal from "@/Jetstream/Modal";
export default {
    components: {
        Modal,
    },

    data () {
        return {
            show: false,
            article: {
                title: '',
                id: '',
            },
        }
    },

    mounted () {
        EventBus.$on('deleteArticle', (data) => {
            this.show = true
            this.article = {...data}
        })
    },

    methods: {
        submit () {
            this.$inertia.delete(`/admin/article/${this.article.id}`, {
                onSuccess: () => this.show = false
            })
        }
    }
}
</script>
