<template>
    <div>
        <div class="view-head">
            <h1 class="title">
                New post
            </h1>

            <div class="buttons are-small">
                <router-link :to="{ name: 'posts.index' }" class="button">
                    Back
                </router-link>
            </div>
        </div>

        <post-form :data="data" :locale="$store.state.defaultLocale" @submit="createPost"></post-form>
    </div>
</template>

<script>
import store from '../../store'
import PostForm from './PostForm'

export default {
    data () {
        return {
            isLoading: false,
            data: {
                post: {},
                errors: [],
            },
        }
    },
    components: {
        PostForm,
    },
    methods: {
        createPost (draft) {
            this.isLoading = true
            this.data.errors = []

            this.data.post.draft = draft

            this.axios
                .post('/api/posts', this.data.post)
                .then(response => {
                    this.$swal({
                        text: response.data.message,
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                    })

                    this.$router.push({
                        name: 'posts.edit',
                        params: {
                            id: response.data.post.id
                        }
                    })
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.data.errors = error.response.data.errors
                    }
                })
                .finally(() => this.isLoading = false)
        }
    }
}
</script>
