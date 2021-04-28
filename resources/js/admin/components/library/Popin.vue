<template>
    <div class="library-modal modal" :class="{'is-active': active}">
        <div class="modal-background"></div>

        <button class="modal-close is-large" aria-label="Close" @click="$emit('close')"></button>

        <div class="modal-content">
            <header class="modal-card-head">
                <div class="level">
                    <div class="level-left">
                        <div>
                            <h2 class="title">
                                Media library
                            </h2>

                            <div class="subtitle is-6">
                                <template v-if="selection.length > 1">
                                    {{ selection.length }} files selected
                                </template>
                                <template v-else>
                                    {{ selection.length }} file selected
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="level-right">
                        <button class="button is-primary" :class="{'is-loading': fileLoading}">
                            <span class="icon">
                                <fa-icon icon="plus"></fa-icon>
                            </span>
                            <span>Upload new file</span>

                            <input ref="file" class="file-input" type="file" @change="uploadFile">
                        </button>
                    </div>
                </div>
            </header>

            <section class="modal-card-body">
                <div class="columns is-multiline">
                    <div class="column is-3" v-if="fileLoading">
                        <div class="library-file box">
                            <figure class="image is-16by9 is-loading">
                                <div class="image-loading-progress">
                                    <span></span>
                                </div>
                            </figure>

                            <p class="library-file-name">
                                Loading...
                            </p>

                            <p class="library-file-size">
                                {{ fileUploadPercentage }}%
                            </p>
                        </div>
                    </div>

                    <div class="column is-3" v-for="file in results.data">
                        <a class="library-file box" :class="{'is-selected': file.selected}" @click="toggleFile(file)">
                            <figure class="image is-16by9">
                                <img :src="file.thumbnail">
                            </figure>

                            <p class="library-file-name">
                                {{ file.filename }}
                            </p>

                            <p class="library-file-size">
                                {{ file.size }}
                            </p>
                        </a>
                    </div>
                </div>

                <pagination :data="results" @pagination-change-page="loadMedia"></pagination>
            </section>

            <footer class="modal-card-foot">
                <button class="button is-primary" :disabled="! selection.length" @click="$emit('select', selection, context)">
                    <template v-if="selection.length > 1">Select files</template>
                    <template v-else>Select file</template>
                </button>

                <button class="button" @click="$emit('close')">
                    Cancel
                </button>
            </footer>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        active: Boolean,
        multiple: Boolean,
        context: String
    },
    data () {
        return {
            results: {},
            isLoading: true,
            fileLoading: false,
            fileUploadPercentage: 0,
            selection: []
        }
    },
    created () {
        this.loadMedia()
    },
    methods: {
        loadMedia (page = 1) {
            this.axios
                .get(`/api/library?page=${page}`)
                .then(response => {
                    this.results = response.data
                    this.isLoading = false
                })
        },
        uploadFile () {
            this.fileLoading = true

            let formData = new FormData()

            formData.append('file', this.$refs.file.files[0])

            axios.post('/api/library', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: ((progress) => {
                    this.fileUploadPercentage = parseInt(Math.round((progress.loaded / progress.total) * 100))
                }).bind(this)
            })
            .then(response => {
                this.results.data.unshift(response.data)
            })
            .catch(error => {
                console.error(error)
            })
            .finally(() => {
                this.fileLoading = false
                this.fileUploadPercentage = 0
            })
        },
        toggleFile (file) {
            if (file.selected) {
                this.selection = this.selection.filter((el) => {
                    return el.id !== file.id
                })

                file.selected = false
            } else {
                // Reset selection
                if (! this.multiple) {
                    this.selection.forEach((item) => {
                        item.selected = false
                    })

                    this.selection = []
                }

                this.selection.push(file)

                file.selected = true
            }
        }
    }
}
</script>
