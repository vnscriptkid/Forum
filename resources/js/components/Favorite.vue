<template>
    <button :class="classes" @click="toggle">
        <span v-text="likeOrUnlike"></span>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
        </svg>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
    import axios from 'axios';

    export default {
        props: ['reply'],
        data() {
            const {favoritesCount, favoritedByMe, id: replyId} = this.reply;
            return {
                favoritesCount,
                favoritedByMe,
                replyId
            }
        },
        computed: {
            likeOrUnlike: function() {
                return this.favoritedByMe ? 'Unlike' : 'Like'
            },
            classes: function() {
                const btnColor =this.favoritedByMe ? 'btn-danger' : 'btn-secondary';
                return ['btn', 'btn-sm', btnColor];
            },
            link: function() {
                return `/replies/${this.replyId}/favorites`;
            }
        },
        methods: {
            toggle() {
                this.favoritedByMe ? this.unlike() : this.like();
            },
            like() {
                axios.post(this.link);
                this.favoritesCount++;
                this.favoritedByMe = true;
                },
            unlike() {
                axios.delete(this.link);
                this.favoritesCount--;
                this.favoritedByMe = false;
            }
        }
    }
</script>
