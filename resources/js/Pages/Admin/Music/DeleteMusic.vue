<template>
    <modal :show="show" @close="show = !show" class="delete_modal">
        <h3 class="harrison text-center mb-4">Attention</h3>
        <p>La musique "{{ music.title }}" est sur le point d'être supprimée. Cette opération est irréversible. Continuer ?</p>

        <div class="actions flex justify-end">
            <button @click="show = !show">Annuler</button>
            <button class="danger" @click="submit">Supprimer</button>
        </div>
    </modal>
</template>

<script>
import Modal from "@/Jetstream/Modal";
import EventBus from "@/Mixins/event-bus";
export default {
    components: {
        Modal,
    },

    data () {
        return {
            show: false,
            music: {
                title: '',
                author: '',
                year: '',
                subtitle: '',
                content: '',
                iframe: '',
            }
        }
    },

    mounted () {
        EventBus.$on('deleteMusicForm', (data) => {
            this.show = true
            this.music = {...data}
        })
    },

    methods: {
        submit () {
            this.$inertia.delete(`/admin/music/${this.music.id}`, {
                onSuccess: () => this.show = false
            })
        }
    }
}
</script>
