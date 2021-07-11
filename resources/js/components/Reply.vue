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
    methods: {
        async update() {
            try {
                await axios.patch(`/replies/${this.attributes.id}`, {
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
        }
    }
}
</script>
