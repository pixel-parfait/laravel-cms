<template>
    <div>
        <div class="view-head">
            <h1 class="title">
                Library
            </h1>
        </div>

        <div class="level">
            <div class="level-left">

            </div>

            <div class="level-right">
                <div class="buttons is-centered">
                    <button class="button is-primary" :class="{'is-loading': fileLoading}">
                        <span class="icon">
                            <fa-icon icon="plus"></fa-icon>
                        </span>
                        <span>Upload new file</span>

                        <input ref="file" class="file-input" type="file" @change="uploadFile">
                    </button>
                </div>
            </div>
        </div>

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
                <a class="library-file box" @click="selectFile(file)">
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

        <file-info :file="activeFile" @close="activeFile = null"></file-info>
    </div>
</template>

<script>
import FileInfo from './FileInfo'

export default {
    data () {
        return {
            results: {},
            isLoading: true,
            fileLoading: false,
            fileUploadPercentage: 0,
            activeFile: null
        }
    },
    created () {
        this.loadMedia()
    },
    components: {
        FileInfo
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
        selectFile (file) {
            this.activeFile = file
        }
    }
}
</script>
