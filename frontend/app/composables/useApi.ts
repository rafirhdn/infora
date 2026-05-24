export const useApi = () => {
  const config = useRuntimeConfig();

  return $fetch.create({
    baseURL: config.public.apiBase,

    credentials: "include",

    headers: {
      Accept: "application/json",
      "X-Requested-With": "XMLHttpRequest",
    },

    onRequest({ options }) {
      const xsrf = useCookie("XSRF-TOKEN").value;

      if (xsrf) {
        options.headers = new Headers(options.headers);

        options.headers.set("X-XSRF-TOKEN", decodeURIComponent(xsrf));
      }
    },
  });
};
