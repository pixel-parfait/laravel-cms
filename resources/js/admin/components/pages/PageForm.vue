<template>
    <div>
        <form @submit.prevent="$emit('submit', 0)" @change="hasChanged = true">
            <div class="columns">
                <div class="column is-8">
                    <div class="box">
                        <div class="field">
                            <label class="label is-required" for="page-title">
                                Title
                            </label>
                            <div class="control">
                                <input v-model="page.title" id="page-title" class="input" type="text" required>
                            </div>

                            <p class="help is-danger" v-if="errors.title">
                                {{ errors.title[0] }}
                            </p>
                        </div>

                        <div class="field">
                            <label class="label is-required" for="page-content">
                                Content
                            </label>
                            <div class="control">
                                <editor v-model="page.content" api-key="no-api-key" :init="tinyInit" ref="editor" />
                            </div>

                            <p class="help is-danger" v-if="errors.content">
                                {{ errors.content[0] }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="column is-4">
                    <div class="box">
                        <h2 class="title is-5">
                            Featured image
                        </h2>

                        <div class="file">
                            <input type="hidden" v-model="page.cover_id">

                            <figure class="file-preview image is-16by9" v-if="page.cover" @click="openFile(page.cover)">
                                <img :src="page.cover.thumbnail" :alt="page.cover.alt">

                                <div class="file-actions">
                                    <div class="button is-danger is-small" role="button" @click="removeCover">
                                        <span class="icon is-small">
                                            <fa-icon icon="trash"></fa-icon>
                                        </span>
                                        <span>Remove image</span>
                                    </div>
                                </div>
                            </figure>

                            <div class="button is-fullwidth" @click="openLibrary('cover')">
                                Select image
                            </div>
                        </div>
                    </div>

                    <div class="box" v-if="page.id">
                        <h2 class="title is-5">
                            Language
                        </h2>

                        <div class="buttons">
                            <button class="button is-uppercase" type="button" v-for="key in $store.state.availableLocales" @click="translate(key)" :class="{'is-primary': key === locale}">
                                {{ key }}
                            </button>
                        </div>
                    </div>

                    <div class="box">
                        <h2 class="title is-5">
                            Publish
                        </h2>

                        <div class="buttons">
                            <button class="button" type="button" :class="{'is-loading': isLoading}" @click="saveDraft()">
                                Save draft
                            </button>

                            <button class="button is-primary" :class="{'is-loading': isLoading}">
                                Publish
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <library
            :active="libraryOpen"
            :context="libraryContext"
            :multiple="false"
            @close="libraryOpen = false"
            @select="selectFile"
        ></library>

        <file-info :file="activeFile" @close="activeFile = null"></file-info>
    </div>
</template>

<script>
import store from '../../store'
import editor from '../../mixins/editor.js'
import library from '../../mixins/library.js'

export default {
    props: {
        data: Object,
        locale: String,
        isLoading: Boolean
    },
    data () {
        return {
            page: this.data.page,
            errors: this.data.errors,
            hasChanged: false
        }
    },
    mixins: [
        editor, library
    ],
    watch: {
        'data.errors': function (array) {
            this.errors = array
        }
    },
    methods: {
        selectFile (selection, context) {
            if (context == 'cover') {
                this.page.cover = selection[0]
                this.page.cover_id = this.page.cover.id
            } else if (context == 'editor') {
                let html = `
                    <figure class="image">
                        <img src="${selection[0].url}" alt="${selection[0].alt}" />
                    </figure>
                `

                tinymce.activeEditor.insertContent(html)
            }

            this.libraryOpen = false
        },
        removeCover () {
            this.page.cover = null
            this.page.cover_id = null
        },
        translate (locale) {
            let route = {}

            if (locale === this.$store.state.defaultLocale) {
                route = { name: 'pages.edit', params: {id: this.page.id} }
            } else {
                route = { name: 'pages.translate', params: {id: this.page.id, locale: locale} }
            }

            if (this.hasChanged) {
                this.$swal({
                    title: "You have unsaved changes",
                    text: "The changes you made will be lost if you leave the page.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.value) {
                        this.$router.push(route)
                    }
                })
            } else {
                this.$router.push(route)
            }
        },
        saveDraft () {
            this.$emit('submit', 1)
        }
    }
}
</script>
