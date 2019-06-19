<template>
    <div>
        <div class="d-flex justify-content-between mt-1" v-for="(attachment, index) in attachments">
            <input @change="onFileChange(index, $event)" type="file" class="form-control-file" :name="'attachment' + index" :id="'attachment' + index">
            <button v-if="showRemove(index)" class="btn btn-link btn-sm" type="button" @click="remove(index)">Remove</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['data'],

        data() {
            return {
                attachments: this.data
            }
        },

        methods: {
            onFileChange(index, event) {
                let file = event.target.files;

                if (!_.isUndefined(file[0])) {
                    this.attachments[index] = file[0];
                } else {
                    this.attachments[index] = '';
                }

                this.emitValue();
            },

            remove(index) {
                this.attachments = _.filter(this.attachments, (item, key) => {
                    return index != key;
                });

                this.emitValue();
            },

            showRemove(index) {
                return index != 0 && this.attachments.lastIndexOf(_.last(this.attachments)) == index;
            },

            emitValue() {
                this.$emit('reloaded-attachments', this.attachments);
            }
        }
    }
</script>