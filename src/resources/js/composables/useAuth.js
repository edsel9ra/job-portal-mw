import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

export function useAuth() {
    const page = usePage()

    const user = computed(() => page.props.auth.user)
    const isReclutador = computed(() => user.value?.isReclutador ?? false)
    const isCandidato = computed(() => user.value?.isCandidato ?? false)
    const roles = computed(() => user.value?.roles ?? [])

    return { user, isReclutador, isCandidato, roles }
}
