<script>

import axios from 'axios';

export default {
    props: ['attributes'],
    data() {
        return {
            editing: false,
            body: this.attributes.body,
            errors: null
        }
    },
    computed: {
        endpoint() {
            return `/replies/${this.attributes.id}`;
        }
    },
    methods: {
        async update() {
            try {
                await axios.patch(this.endpoint, {
                    body: this.body
                });
                this.editing = false;
                flash('Reply updated');
            } catch (e) {
                this.errors = e.response.data;
            }
        },
        cancel() {
            this.body = this.attributes.body;
            this.editing = false;
        },
        destroy() {
            axios.delete(this.endpoint);
            $(this.$el).fadeOut(200, () => {
                flash('Reply deleted!');
            });
        }
    }
}
</script>
