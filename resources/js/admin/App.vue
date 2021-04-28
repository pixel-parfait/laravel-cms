<template>
    <div>
        <nav class="navbar is-dark is-fixed-top" role="navigation">
            <div class="navbar-brand">
                <a class="navbar-item has-text-weight-bold" :href="url">
                    {{ name }}
                </a>
            </div>

            <div class="navbar-end">
                <div class="navbar-item">
                    <span>{{ user.full_name }}</span>

                    <a href="/admin/logout" class="icon">
                        <fa-icon icon="power-off"></fa-icon>
                    </a>
                </div>
            </div>
        </nav>

        <div id="sidebar">
            <aside class="menu" role="navigation">
                <ul class="menu-list">
                    <li>
                        <router-link :to="{ name: 'posts.index' }">
                            <span class="icon">
                                <fa-icon icon="newspaper"></fa-icon>
                            </span>
                            Posts
                        </router-link>
                    </li>

                    <li>
                        <router-link :to="{ name: 'pages.index' }">
                            <span class="icon">
                                <fa-icon icon="file"></fa-icon>
                            </span>
                            Pages
                        </router-link>
                    </li>

                    <li>
                        <router-link :to="{ name: 'library.index' }">
                            <span class="icon">
                                <fa-icon icon="photo-video"></fa-icon>
                            </span>
                            Library
                        </router-link>
                    </li>
                </ul>
            </aside>
        </div>

        <div id="main-content">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        name: String,
        url: String,
        user: Object,
        defaultLocale: String,
        availableLocales: Array
    },
    created () {
        this.$store.commit('setDefaultLocale', this.defaultLocale)
        this.$store.commit('setAvailableLocales', this.availableLocales)
    }
}
</script>
