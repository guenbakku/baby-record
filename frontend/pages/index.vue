<script lang="ts">
import { defineComponent } from '@vue/composition-api'

export default defineComponent({
  fetch({ redirect }) {
    redirect({ name: 'activities-date' })
  }
})
</script>
