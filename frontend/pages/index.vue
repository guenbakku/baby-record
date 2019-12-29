<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  fetch({ redirect }) {
    redirect({ name: 'activities-date' })
  }
})
</script>
