import AllPosts from './components/posts/AllPosts.vue'
import CreatePost from './components/posts/CreatePost.vue'
import EditPost from './components/posts/EditPost.vue'
import TranslatePost from './components/posts/TranslatePost.vue'

import AllPages from './components/pages/AllPages.vue'
import CreatePage from './components/pages/CreatePage.vue'
import EditPage from './components/pages/EditPage.vue'
import TranslatePage from './components/pages/TranslatePage.vue'

import Library from './components/library/Library.vue'

import PageNotFound from './components/errors/PageNotFound.vue'

export const routes = [
    {
        name: 'home',
        path: '/admin',
        redirect: '/admin/posts'
    },

    {
        name: 'posts.index',
        path: '/admin/posts',
        component: AllPosts
    },
    {
        name: 'posts.create',
        path: '/admin/posts/create',
        component: CreatePost
    },
    {
        name: 'posts.edit',
        path: '/admin/posts/:id/edit',
        component: EditPost
    },
    {
        name: 'posts.translate',
        path: '/admin/posts/:id/translate/:locale',
        component: TranslatePost
    },

    {
        name: 'pages.index',
        path: '/admin/pages',
        component: AllPages
    },
    {
        name: 'pages.create',
        path: '/admin/pages/create',
        component: CreatePage
    },
    {
        name: 'pages.edit',
        path: '/admin/pages/:id/edit',
        component: EditPage
    },
    {
        name: 'pages.translate',
        path: '/admin/pages/:id/translate/:locale',
        component: TranslatePage
    },

    {
        name: 'library.index',
        path: '/admin/library',
        component: Library
    },

    {
        path: "/admin/*",
        component: PageNotFound
    },
]
