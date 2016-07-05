# Lelesys.News

Please find documentation at following link:

http://www.lelesys.com/en/technology/about-typo3-neos/neos-packages/news-package-extension-for-typo3-neos.html

Even though it is for the first version, it still is valid.

## Using Elasticsearch

To speed up handling of news filtering and sorting, using Elasticsearch is recommended.

If you have the installed `flowpack/elasticsearch-contentrepositoryadaptor` (and its dependencies), news
will be indexed correctly. If you already have created news before installing the Elasticsearch adaptor,
run `./flow nodeindex:build` to create the index.

The configure the plugin to use Elasticsearch to fetch the news add this to your TypoScript:

```
prototype(Lelesys.News:List) {
    newsCollection = Lelesys.News:ElasticsearchNewsCollector
}

prototype(Lelesys.News:Latest) {
    newsCollection.value.@process.slice = ${value.limit(String.toInteger(configuration.numberOfItems))}
    newsCollection.value.@process.toArray = ${value.toArray()}
    newsCollection.value.@process.toArray.@position = 'after execute'
}
```

To enable logging of the queries sent to Elasticsearch (`Data/Logs/ElasticSearch.log`), you can do:

```
newsCollection = Lelesys.News:ElasticsearchNewsCollector {
    value.@process.log = ${value.log()}
    value.@process.log.@position = 'before execute'
}
```

Similarly you can adjust the query by adding further filters, the `value` in the collector is an instance
of the `ElasticSearchQueryBuilder`:

```
newsCollection = Lelesys.News:ElasticsearchNewsCollector {
    # exclude "hidden in menu" entries from the List`s news collection
    value.@process.filterHiddenInIndex= ${value.queryFilter('term', {'_hiddenInIndex': true}, 'must_not')}
    value.@process.filterHiddenInIndex.@position = 'before execute'
}
```
