import fs from "fs";
import path from "path";
import { fileURLToPath } from "url";
import { load } from "cheerio";
import TurndownService from "turndown";

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

const outDir = path.join(__dirname, "readable_md");
if (!fs.existsSync(outDir)) {
  fs.mkdirSync(outDir);
}

const turndown = new TurndownService({
  headingStyle: "atx",
  bulletListMarker: "-",
  codeBlockStyle: "fenced",
});

const htmlFiles = fs
  .readdirSync(__dirname)
  .filter((name) => name.endsWith(".html"))
  .sort((a, b) => a.localeCompare(b));
const mdFileNames = new Set(
  htmlFiles.map((name) => name.replace(/\.html$/i, ".md")),
);

function rewriteInternalHref(href) {
  if (!href) {
    return href;
  }

  const value = href.trim();
  if (/^(https?:|mailto:|tel:|#|javascript:)/i.test(value)) {
    return value;
  }

  let docPath = null;
  if (value.startsWith("/creatorsapi/docs/")) {
    docPath = value.slice("/creatorsapi/docs/".length);
  } else if (value.startsWith("en-us/")) {
    docPath = value;
  } else {
    return value;
  }

  const withoutQuery = docPath.split("?")[0];
  const hashIndex = withoutQuery.indexOf("#");
  let pathPart = withoutQuery;
  let fragment = "";

  if (hashIndex >= 0) {
    pathPart = withoutQuery.slice(0, hashIndex);
    fragment = withoutQuery.slice(hashIndex + 1);
  }

  const normalizedPath = pathPart.replace(/^\/+/, "").replace(/\/+$/, "");
  if (!normalizedPath) {
    return value;
  }

  const localStem = "_creatorsapi_docs_" + normalizedPath.replace(/\//g, "_");

  if (fragment) {
    const fragmentFile = localStem + "#" + fragment + ".md";
    if (mdFileNames.has(fragmentFile)) {
      return "./" + fragmentFile;
    }
  }

  const baseFile = localStem + ".md";
  if (mdFileNames.has(baseFile)) {
    if (fragment) {
      return "./" + baseFile + "#" + fragment;
    }
    return "./" + baseFile;
  }

  // Fallback: if a deep route was not captured as its own HTML file,
  // link to the closest existing parent page.
  let parentPath = normalizedPath;
  while (parentPath.includes("/")) {
    parentPath = parentPath.slice(0, parentPath.lastIndexOf("/"));
    const parentStem = "_creatorsapi_docs_" + parentPath.replace(/\//g, "_");
    const parentFile = parentStem + ".md";
    if (mdFileNames.has(parentFile)) {
      return "./" + parentFile;
    }
  }

  return value;
}

function rewriteStaticAssetUrl(url) {
  if (!url) {
    return url;
  }
  const value = url.trim();
  if (value.startsWith("/creatorsapi/docs/")) {
    const relativePath = value
      .slice("/creatorsapi/docs/".length)
      .replace(/^\/+/, "");
    return "./" + relativePath;
  }
  return value;
}

const combined = [];
combined.push("# Creators API Docs (Readable Markdown)");
combined.push("");
combined.push("Total files converted: " + String(htmlFiles.length));
combined.push("");

for (const file of htmlFiles) {
  const fullPath = path.join(__dirname, file);
  const raw = fs.readFileSync(fullPath, "utf8");
  const $ = load(raw);

  let source = $("div.markdown-content").first();
  if (!source.length) {
    source = $("main").first();
  }
  if (!source.length) {
    source = $("body").first();
  }
  if (!source.length) {
    source = $.root();
  }

  source.find("script, style, noscript").remove();
  source.find("a[href]").each((_, element) => {
    const currentHref = $(element).attr("href");
    const rewrittenHref = rewriteInternalHref(currentHref);
    if (rewrittenHref && rewrittenHref !== currentHref) {
      $(element).attr("href", rewrittenHref);
    }
  });
  source.find("img[src]").each((_, element) => {
    const currentSrc = $(element).attr("src");
    const rewrittenSrc = rewriteStaticAssetUrl(currentSrc);
    if (rewrittenSrc && rewrittenSrc !== currentSrc) {
      $(element).attr("src", rewrittenSrc);
    }
  });

  const h1 = source.find("h1").first().text().trim();
  const titleTag = $("title").first().text().trim();
  const title = h1 || titleTag || file.replace(/\.html$/i, "");

  const markdownBody = turndown
    .turndown(source.html() || "")
    .replace(/\n{3,}/g, "\n\n")
    .trim();

  const outputName = file.replace(/\.html$/i, ".md");
  const outputPath = path.join(outDir, outputName);
  const header = "# " + title + "\n\nSource: `" + file + "`\n\n";
  fs.writeFileSync(outputPath, header + markdownBody + "\n", "utf8");

  combined.push("## " + title);
  combined.push("");
  combined.push("Source: `" + file + "`");
  combined.push("");
  combined.push(markdownBody);
  combined.push("");
}

const combinedPath = path.join(__dirname, "CREATORSAPI_READABLE_ALL.md");
fs.writeFileSync(combinedPath, combined.join("\n"), "utf8");

console.log("Converted " + String(htmlFiles.length) + " HTML files into " + outDir);
console.log("Created combined file: " + combinedPath);
