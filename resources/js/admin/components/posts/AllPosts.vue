<template>
    <div>
        <div class="view-head">
            <h1 class="title">
                Posts
            </h1>
        </div>

        <div class="level">
            <div class="level-left">

            </div>

            <div class="level-right">
                <router-link :to="{ name: 'posts.create' }" class="button is-primary">
                    <span class="icon">
                        <fa-icon icon="plus"></fa-icon>
                    </span>
                    <span>New post</span>
                </router-link>
            </div>
        </div>

        <table class="table is-striped is-fullwidth">
            <thead>
                <tr>
                    <th>Title</th>
                    <th width="180">Created at</th>
                    <th width="130"></th>
                </tr>
            </thead>

            <tbody v-if="isLoading && ! results.data">
                <tr>
                    <td colspan="3" align="center">
                        <div class="loading-spinner"></div>
                    </td>
                </tr>
            </tbody>

            <tbody v-else-if="results.data.length">
                <tr v-for="post in results.data">
                    <td>
                        {{ post.title }}
                        <span class="tag is-warning" v-if="post.draft">Draft</span>
                    </td>
                    <td>
                        {{ post.created_at | date }}
                    </td>
                    <td>
                        <div class="buttons is-right">
                            <router-link class="button is-small" :to="{ name: 'posts.edit', params: {id: post.id} }" title="Edit post">
                                <span class="icon is-small">
                                    <fa-icon icon="edit"></fa-icon>
                                </span>
                            </router-link>

                            <button class="button is-small" title="Delete post" @click="deletePost(post.id)">
                                <span class="icon is-small">
                                    <fa-icon icon="trash"></fa-icon>
                                </span>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>

            <tbody v-else>
                <tr>
                    <td colspan="3">
                        You didn't create any post yet.
                    </td>
                </tr>
            </tbody>
        </table>

        <pagination :data="results" @pagination-change-page="loadPosts"></pagination>
    </div>
</template>

<script>
export default {
    data () {
        return {
            results: {},
            isLoading: true
        }
    },
    created () {
        this.loadPosts()
    },
    methods: {
        loadPosts (page = 1) {
            this.axios
                .get(`/api/posts?page=${page}`)
                .then(response => {
                    this.results = response.data
                    this.isLoading = false
                })
        },
        deletePost (id) {
            this.$swal({
                title: "Confirm",
                text: 'Do you wish to remove this post?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.value) {
                    this.axios
                        .delete(`/api/posts/${id}`)
                        .then(response => {
                            let index = this.results.data.map(item => item.id).indexOf(id)

                            this.results.data.splice(index, 1)
                            this.total--

                            this.$swal({
                                text: response.data,
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                            })
                        })
                }
            })
        }
    }
}
</script>
