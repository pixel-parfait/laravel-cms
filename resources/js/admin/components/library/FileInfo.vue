<template>
    <div class="file-modal modal is-active" v-if="file">
        <div class="modal-background"></div>

        <button class="modal-close is-large" aria-label="Close" @click="$emit('close')"></button>

        <form class="modal-content" @submit.prevent="updateFile">
            <header class="modal-card-head">
                <h2 class="title">
                    File info
                </h2>
            </header>

            <section class="modal-card-body">
                <div class="columns">
                    <div class="column is-6">
                        <figure class="image is-16by9">
                            <img :src="file.thumbnail">
                        </figure>
                    </div>

                    <div class="column is-6">
                        <div class="field">
                            <label class="label" for="file-filename">
                                File name
                            </label>
                            <div class="control">
                                <input v-model="file.filename" id="file-filename" class="input" type="text" disabled>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label" for="file-size">
                                Size
                            </label>
                            <div class="control">
                                <input v-model="file.size" id="file-size" class="input" type="text" disabled>
                            </div>
                        </div>

                        <div class="field">
                            <label class="label" for="file-alt">
                                Alternative text
                            </label>
                            <div class="control">
                                <input v-model="file.alt" id="file-alt" class="input" type="text">
                            </div>

                            <p class="help is-danger" v-if="errors.alt">
                                {{ errors.alt[0] }}
                            </p>
                        </div>

                        <div class="field">
                            <label class="label" for="file-caption">
                                Caption
                            </label>
                            <div class="control">
                                <textarea v-model="file.caption" id="file-caption" class="textarea" rows="2"></textarea>
                            </div>

                            <p class="help is-danger" v-if="errors.caption">
                                {{ errors.caption[0] }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="modal-card-foot">
                <button class="button is-primary" :class="{'is-loading': isLoading}">
                    Save
                </button>

                <button class="button" :class="{'is-loading': isLoading}" @click="$emit('close')">
                    Cancel
                </button>
            </footer>
        </form>
    </div>
</template>

<script>
export default {
    props: {
        file: Object
    },
    data () {
        return {
            isLoading: false,
            errors: []
        }
    },
    methods: {
        updateFile () {
            this.isLoading = true
            this.errors = []

            this.axios
                .post('/api/library/' + this.file.id, {
                    _method: 'put',
                    ...this.file
                })
                .then(response => {
                    this.$swal({
                        text: response.data,
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                    })

                    this.$emit('close')
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors
                    }
                })
                .finally(() => this.isLoading = false)
        }
    }
}
</script>
