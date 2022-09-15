<template>
    <div class="card mt-3">
        <!-- <img src="..." class="card-img-top" alt="..."> -->
        <div class="card-body">
            <img class="w-100" v-if="post.cover" :src="post.cover" :alt="post.title">
            
            <div class="text-center">
                <h5 class="card-title">{{post.title}}</h5>
                <p class="card-text">{{truncateText(post.content)}}</p>
                <router-link class="btn btn-primary" 
                :to="{
                    name: 'single-post', 
                    params: {slug: post.slug}
                }">
                    Find out more
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PostDetails',
    props: {
        post: Object
    },
    methods: {
        truncateText(text) {
            if(text.length > 100) {
                return text.slice(0, 100) + '...'
            }

            return text;
        }
    }
}
</script>
