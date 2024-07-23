<template>
    <modal :show="show" @close="show = !show" class="delete_modal">
        <h3 class="harrison text-center">Gestion des tags</h3>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-black">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Titre français
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                                    Titre anglais
                                </th>

                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="tag in tags" :key="tag.id">
                                <td class="px-6 py-4 whitespace-nowrap control">
                                    <input type="text" v-model="tag.fr" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap control">
                                    <input type="text" v-model="tag.en" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button @click.prevent="submit(tag)" :data-id="tag.id">Enregistrer</button>
                                    <button @click.prevent="remove(tag)">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-2">
            <button @click.prevent="addRow">+</button>
        </div>

        <div class="actions">
            <button @click.prevent="show = false">Fermer</button>
        </div>
    </modal>
</template>

<script>
import EventBus from "@/Mixins/event-bus";
import Modal from "@/Jetstream/Modal"
import Button from "@/Jetstream/Button";
import Form from "@/Pages/Admin/Articles/Form";
export default {
    components: {
        Form,
        Button,
        Modal,
    },

    data () {
        return {
            show: false,
            tags: []
        }
    },

    mounted () {
        EventBus.$on('handleTags', () => {
            this.show = true;
            axios.get(' /admin/tags')
            .then((data) => this.tags = data.data)
        })
    },

    methods: {
        submit (tag) {
            axios.post('/admin/tag', tag)
                .then((data) => {
                    const button = document.querySelector(`button[data-id="${tag.id}"]`)
                    button.innerHTML = 'Enregistré';
                    setTimeout(() => button.innerHTML = 'Enregistrer', 2000);
                    this.tags = data.data
                    this.$emit('updateTags')
                });
        },

        addRow () {
            const buttons = document.querySelectorAll("button[data-id]")
            const ids = [];
            for (let b of buttons) {
                ids.push(parseInt(b.dataset.id));
            }
            this.tags.push({fr: '', en: '', created: true, id: Math.max.apply(Math, ids) + 1})
        },

        remove (tag) {
            axios.delete(`/admin/tag/${tag.id}`)
            .then((data) => {
                this.tags = data.data;
                this.$emit('updateTags');
            })
        }
    }
}
</script>
