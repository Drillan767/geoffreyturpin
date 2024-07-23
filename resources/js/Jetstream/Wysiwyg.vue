<template>
    <div>
        <editor
            :api-key="tiny_secret"
            :init="init"
            v-model="wysiwygData"
        />
    </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue';
export default {
    props: ['value', 'tiny_secret'],
    components: {
        editor: Editor,
    },

    data () {
        return {
            init: {
                entity_encoding: 'raw',
                images_upload_handler: this.imageHandler,
                height: 500,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks codesample fullscreen',
                    'insertdatetime media table code wordcount imagetools',
                ],
                toolbar:
                    'formatselect | bold italic forecolor backcolor | \
                    alignleft aligncenter alignright alignjustify table | \
                    codesample bullist numlist outdent indent image | \
                    removeformat undo redo fullscreen',

            },
        }
    },

    methods: {
        imageHandler (blobInfo, success, failure, progress) {
            let preview = URL.createObjectURL(blobInfo.blob());
            this.$emit('upload', {uuid: preview, image: blobInfo.blob()})
            success(preview);
        }
    },

    computed: {
        wysiwygData: {
            get () {
                return this.value;
            },

            set (val) {
                this.$emit('input', val)
            }
        }
    }
}
</script>
