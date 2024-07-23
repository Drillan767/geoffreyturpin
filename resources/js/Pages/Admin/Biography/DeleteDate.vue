<template>
    <modal :show="show" @close="show = !show" class="delete_modal">
        <h3 class="harrison text-center mb-4">Attention</h3>
        <p>La date <b>{{ event.year }}</b> est sur le point d'être supprimée. Cette opération est irréversible. Continuer ?</p>

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
            event: {
                year: '',
                text: '',
            }
        }
    },

    mounted () {
        EventBus.$on('deleteDateForm', (data) => {
            this.show = true
            this.event = {...data}
        })
    },

    methods: {
        submit () {
            this.$inertia.delete(`/admin/biographie/${this.event.id}`, {
                onSuccess: () => this.show = false
            })
        }
    }
}
</script>
